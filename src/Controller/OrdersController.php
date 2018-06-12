<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Orders Controller
 *
 *
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
    public function initialize()
    {
       session_start();
       parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->sessionCheck();
        $orders = $this->paginate($this->Orders);

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->sessionCheck();
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);

        $this->set('order', $order);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->sessionCheck();
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->sessionCheck();
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->sessionCheck();
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Checkout method
     * @return \Cake\Http\Response|null
     */
    public function checkout()
    {
        $this->sessionCheck();
        $this->loadModel('Basket');
        $this->loadModel('Cookie');

        $cookie = $this->Cookie->find()->where(['cookieuser' => $_COOKIE['cookieuser']])->contain(['User'])->first();
        $basketItems = $this->Basket->find()->where(['user_id' => $cookie->user->id])->contain(['Item']);
        foreach($basketItems as $basketItem) 
        {
            $order = $this->Orders->newEntity();
            $order->user_id = $cookie->user_id;
            $order->item_id = $basketItem->item_id;
            $order->quantity = $basketItem->quantity;
            $order->price = $basketItem->price;
            $order->amount = ($order->quantity)*($order->price);
            $order->orderdate = time();
            $this->Orders->save($order);

            $basketInfo =  $this->Basket->get($basketItem->id);
            $this->Basket->delete($basketInfo);
        }

        return $this->redirect(['action' => 'message']);
    }

    /**
     * deliveryAddress method
     */
    public function deliveryAddress()
    {
        $this->sessionCheck();
        $this->loadModel('Cookie');

        $user_details = $this->Cookie->find()->where(['cookieuser' => $_COOKIE['cookieuser']])->contain(['User'])->first();
        $this->set(compact('user_details'));
    }

    /**
     * message method
     */
    public function message()
    {
        $this->sessionCheck();
        $this->loadModel('Cookie');
        $this->loadModel('User');
        $cookie = $this->Cookie->find()->where(['cookieuser' => $_COOKIE['cookieuser']])->first();
        $user = $this->User->find()->where(['id' => $cookie->user_id])->first();
        $this->set(compact('user'));
    }


    /**
     * SessionCheck method
     * @return \Cake\Http\Response|null
     */
    public function sessionCheck()
    {
        if(empty($_COOKIE['cookieuser']) || !(isset($_COOKIE['cookieuser']))) {
            $this->Flash->warning(__('Your session is expired. Try to login again.'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
        }
    }

    /**
     * deliveryAddressEdit method
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function deliveryAddressEdit($id = null)
    {
        $this->sessionCheck();
        $this->loadModel('User');
        $user = $this->User->get($id, [
            'contain' => []
        ]);


        $cookieInfo = $this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->first();

        if($cookieInfo->user_id == $id)
        {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $useraddress = $this->request->getData();

                $user = $this->User->patchEntity($user, $useraddress);

                if($useraddress['csrf_code'] == $_SESSION['token']) {
                    $user->address = htmlentities($useraddress['address']);
                    if ($this->User->save($user)) {
                        $this->Flash->success(__('The user address is updated'));

                        return $this->redirect(['action' => 'delivery-address']);
                    }
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));

                } else {

                    $this->Flash->error(__('Please logout and login again.'));
                    return $this->redirect(['controller' => 'Item', 'action' => 'index']);
                }
            }
            $this->set(compact('user'));
        } else {
            $this->Flash->error(__('Sorry you don\'t have permissions to access to data'));
            return $this->redirect(['action' => 'delivery-address']);
        }



    }


    public function creditCardEdit($id = null)
    {
        $this->sessionCheck();
        $this->loadModel('User');

        $user = $this->User->get($id, [
            'contain' => []
        ]);

        $cookieInfo = $this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->first();

        if($cookieInfo->user_id == $id)
        {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $userCreditCard = $this->request->getData();

                $user = $this->User->patchEntity($user, $userCreditCard);
                if($userCreditCard['csrf_code'] == $_SESSION['token']) {
                    $user->credit_card = htmlentities($userCreditCard['credit_card']);
                    if ($this->User->save($user)) {
                        $this->Flash->success(__('The user credit card details are updated.'));

                        return $this->redirect(['action' => 'delivery-address']);
                    }
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                } else {

                    $this->Flash->error(__('Please logout and login again.'));
                    return $this->redirect(['controller' => 'Item', 'action' => 'index']);
                }
            }
            $this->set(compact('user'));
        } else {
            $this->Flash->error(__('Sorry you don\'t have permissions to access to data'));
            return $this->redirect(['action' => 'delivery-address']);
        }
    }
}
