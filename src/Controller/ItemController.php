<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Item Controller
 *
 * @property \App\Model\Table\ItemTable $Item
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemController extends AppController
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
        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = md5(openssl_random_pseudo_bytes(32));
        }

        $item = $this->paginate($this->Item);

        $this->set(compact('item'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Item->get($id, [
            'contain' => ['Basket', 'Orders']
        ]);

        $this->set('item', $item);
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
            $item = $this->Item->newEntity();
            if ($this->request->is('post')) {
                $item = $this->Item->patchEntity($item, $this->request->getData());
                if ($this->Item->save($item)) {
                    $this->Flash->success(__('The item has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
            $this->set(compact('item'));
        } else {
            $this->Flash->error(__('Page not found'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);

        }

    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Cookie');

        $adminRole =$this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->contain(['User'])->first();

        if($adminRole->user->role === 'ADMIN') {
            $this->sessionCheck();
            $item = $this->Item->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $item = $this->Item->patchEntity($item, $this->request->getData());
                if ($this->Item->save($item)) {
                    $this->Flash->success(__('The item has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
            $this->set(compact('item'));
        } else {
            $this->Flash->error(__('Page not found'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);

        }

    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel('Cookie');

        $adminRole =$this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->contain(['User'])->first();

        if($adminRole->user->role === 'ADMIN') {
            $this->sessionCheck();
            $this->request->allowMethod(['post', 'delete']);
            $item = $this->Item->get($id);
            if ($this->Item->delete($item)) {
                $this->Flash->success(__('The item has been deleted.'));
            } else {
                $this->Flash->error(__('The item could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Page not found'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);

        }

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
