<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * User Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserController extends AppController
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
        $user = $this->paginate($this->User);
        $this->set(compact('user'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->User->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->User->newEntity();
        if ($this->request->is('post')) {
            $user = $this->User->patchEntity($user, $this->request->getData());
            $user->password = password_hash($user->password, PASSWORD_BCRYPT);
            
            if ($this->User->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->User->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->User->patchEntity($user, $this->request->getData());
            if ($this->User->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->User->get($id);
        if ($this->User->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login($cookie_data = false, $edit = false, $id = null)
    {
        if(!isset($_COOKIE['cookieuser'])) {
            if ($this->request->is('post')) {
                $user = $this->request->getData();
                $userInfo = $this->User->find()->where(['email' => $user['username']])->first();

                if(!empty($userInfo)) {
                    if(password_verify($user['password'], $userInfo->password)) {
                        $this->loadModel('Cookie');
                        
                        setcookie('cookieuser', $_SESSION['token'], time()+600, '/', "", null, true);
                        $cookie = $this->Cookie->newEntity();
                        $cookie->cookieuser = strval($_SESSION['token']);
                        $cookie->user_id = $userInfo->id;
                        $cookie->logged_in = true;
                        $cookie->login_expire = time()+60;
                        if($user['csrf_code'] == $_SESSION['token']) {
                            $this->Cookie->save($cookie);
                        }
                        
                        if($cookie_data) {
                            return $this->redirect(['controller' => 'Basket', 'action' => 'index']);
                        } else {
                            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
                        }
                    } else {
                        return $this->redirect(['controller' => 'User', 'action' => 'login']);
                    }
                } else {
                    echo 'NO login';
                    return $this->redirect(['controller' => 'User', 'action' => 'login']);
                }

            }
        } else {
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
        }
    }
}
