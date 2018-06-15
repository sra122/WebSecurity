<?php
namespace App\Controller;

/**
 * Basket Controller
 *
 *
 * @method \App\Model\Entity\Basket[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BasketController extends AppController
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
        $this->loadModel('Cookie');
        if(isset($_COOKIE['cookieuser'])) {
            $userDetails = $this->Cookie->find()->where(['cookieuser' => $_COOKIE['cookieuser']])->contain(['User'])->first();
            $basket = $this->paginate($this->Basket->find('all')->where(['user_id' => $userDetails->user->id])->contain(['Item']));
            $cookie = $this->Cookie->find()->where(['cookieuser' => $_COOKIE['cookieuser']])->first();
            $this->set(compact('basket', 'cookie'));
        } else {
            return $this->redirect(['controller' => 'User', 'action' => 'login']);
        } 
    }

    /**
     * View method
     *
     * @param string|null $id Basket id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Cookie');

        $adminRole =$this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->contain(['User'])->first();

        if($adminRole->user->role === 'ADMIN') {
            $this->sessionCheck();
            $basket = $this->Basket->get($id, [
                'contain' => []
            ]);

            $this->set('basket', $basket);
        } else {
            $this->Flash->error(__('Page not found'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
        }

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Cookie');

        $adminRole =$this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->contain(['User'])->first();

        if($adminRole->user->role === 'ADMIN') {
            $this->sessionCheck();
            $basket = $this->Basket->newEntity();
            if ($this->request->is('post')) {
                $basket = $this->Basket->patchEntity($basket, $this->request->getData());
                if ($this->Basket->save($basket)) {
                    $this->Flash->success(__('The basket has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The basket could not be saved. Please, try again.'));
            }
            $this->set(compact('basket'));
        }

    }

    /**
     * Edit method
     *
     * @param string|null $id Basket id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->sessionCheck();
        $this->loadModel('Cookie');
        $basket = $this->Basket->get($id, [
            'contain' => ['Item']
        ]);
        $cookieInfo = $this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->first();

        // testing current user id and cookie belongs to same user or not
        if($cookieInfo->user_id == $basket->user_id) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $editBasket = $this->request->getData();
                $basket->quantity = $editBasket['quantity'];
                $basket->price = ($basket->quantity)*($basket->item->price);
                if(isset($_COOKIE['cookieuser'])) {
                    if ($this->Basket->save($basket)) {
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    return $this->redirect(['controller' => 'User', 'action' => 'login', 'edit' => true, 'id' => $id]);
                }

                $this->Flash->error(__('The basket could not be saved. Please, try again.'));
            }
            $this->set(compact('basket'));
        } else {
            $this->Flash->error(__('Sorry you don\'t have permissions to access the data'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
        }


    }

    /**
     * Delete method
     *
     * @param string|null $id Basket id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->sessionCheck();
        $this->loadModel('Cookie');
        $basket = $this->Basket->get($id, [
            'contain' => ['Item']
        ]);
        $cookieInfo = $this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->first();

        // testing current user id and cookie belongs to same user or not
        if($cookieInfo->user_id == $basket->user_id) {
            $this->request->allowMethod(['post', 'delete']);
            $basket = $this->Basket->get($id);
            if ($this->Basket->delete($basket)) {
                $this->Flash->success(__('The basket has been deleted.'));
            } else {
                $this->Flash->error(__('The basket could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Sorry you don\'t have permissions to access the data'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
        }

    }


    /**
     * addcart Method
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function addCart($id = null)
    {
        if(!isset($_COOKIE['cookieuser'])) {
            return $this->redirect(['controller' => 'user',
                                    'action' => 'login'
                                    ]);
        }
        $this->loadModel('Item');
        $this->loadModel('Cookie');
        $cookieInfo = $this->Cookie->find()->where(['cookieuser' => $_COOKIE['cookieuser']])->first();

        if ($this->request->is('post')) {
            $addbasket = $this->request->getData();
            $item_details = $this->Item->find()->where(['id' => $id])->first();
            $basket = $this->Basket->newEntity();
            $basket->cookieuser = $_COOKIE['cookieuser'];
            $basket->item_id = $id;
            $basket->user_id = $cookieInfo->user_id;
            if(!empty($addbasket['quantity'])) {
                $basket->quantity = $addbasket['quantity'];
                $basket->price = ($item_details->price)*($basket->quantity);
                $this->Basket->save($basket);
                $this->Flash->success(__('Your item is successfully added to the cart'));
            }
        }
        return $this->redirect(['controller' => 'Item', 'action' => 'index']);

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
}
