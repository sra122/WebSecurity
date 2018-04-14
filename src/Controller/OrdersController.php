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

    public function checkout($cookie = null)
    {
        $this->sessionCheck();
        if(empty($cookie)) {
            setcookie('cookieuser', $_SESSION['token'], time()+600, '/', "", null, true);
        }
        
        $this->loadModel('Basket');
        $this->loadModel('Cookie');
        $user = $this->Cookie->find()->where(['cookieuser' => $cookie])->contain(['User'])->first();
        $basketItems = $this->Basket->find()->where(['cookieuser' => $cookie])->contain(['Item']);
        foreach($basketItems as $basketItem) 
        {
            $order = $this->Orders->newEntity();
            $order->user_id = $user->user_id;
            $order->item_id = $basketItem->item_id;
            $order->quantity = $basketItem->quantity;
            $order->price = $basketItem->price;
            $order->amount = ($order->quantity)*($order->price);
            $order->orderdate = time();
            $this->Orders->save($order);
        }

        return $this->redirect(['action' => 'message', $cookie]);
        
        
    }

    public function message($cookie)
    {
        $this->sessionCheck();
        $this->loadModel('Cookie');
        $user = $this->Cookie->find()->where(['cookieuser' => $cookie])->contain(['User'])->first();
        $this->set(compact('user'));
    }

    public function sessionCheck()
    {
        if(empty($_SESSION['token']) || !(isset($_SESSION['token']))) {
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
        }
    }
}
