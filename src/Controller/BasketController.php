<?php
namespace App\Controller;

use App\Controller\AppController;

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
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if(isset($_COOKIE['cookieuser'])) {
            $basket = $this->paginate($this->Basket->find('all')->where(['cookieuser' => $_COOKIE['cookieuser']])->contain(['Item']));
            $this->set(compact('basket'));
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
        $basket = $this->Basket->get($id, [
            'contain' => []
        ]);

        $this->set('basket', $basket);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
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

    /**
     * Edit method
     *
     * @param string|null $id Basket id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $basket = $this->Basket->get($id, [
            'contain' => ['Item']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $editBasket = $this->request->getData();
            $basket->price = $editBasket['price'];
            $basket->quantity = $editBasket['quantity'];
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
        $this->request->allowMethod(['post', 'delete']);
        $basket = $this->Basket->get($id);
        if ($this->Basket->delete($basket)) {
            $this->Flash->success(__('The basket has been deleted.'));
        } else {
            $this->Flash->error(__('The basket could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function addcart($id = null)
    {
        if(!isset($_COOKIE['cookieuser'])) {
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'cookie' => true]);
        }
        $this->loadModel('Item');
        if ($this->request->is('post')) {
            $addbasket = $this->request->getData();
            $item_details = $this->Item->find()->where(['id' => $id])->first();
            $basket = $this->Basket->newEntity();
            $basket->cookieuser = $_COOKIE['cookieuser'];
            $basket->item_id = $id;
            $basket->price = $item_details->price;
            if(!empty($addbasket['quantity'])) {
                $basket->quantity = $addbasket['quantity'];
                $this->Basket->save($basket);
            }
        }
        return $this->redirect(['controller' => 'Item', 'action' => 'index']);

    }
}
