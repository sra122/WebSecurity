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
        $this->sessionCheck();
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
            $newUser = $this->request->getData();
            $user = $this->User->patchEntity($user, $newUser);
            $user->firstname = htmlentities($newUser['firstname']);
            $user->lastname = htmlentities($newUser['lastname']);
            $user->email = htmlentities($newUser['email']);

            // Hashing the password using bcrypt algorithm
            $user->password = password_hash($user->password, PASSWORD_BCRYPT);

            if ($this->User->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index', 'controller' => 'Item']);
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
        $this->sessionCheck();
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
        $this->sessionCheck();
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->User->get($id);
        if ($this->User->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if(!isset($_COOKIE['cookieuser']) || empty($_COOKIE['cookieuser'])) {
            if ($this->request->is('post')) {
                $user = $this->request->getData();

                //Get the user details from the UserDatabase.
                $userInfo = $this->User->find()->where(['email' => $user['username']])->first();

                if(!empty($userInfo)) {
                    // password_verify is a php function used to check the user password with hashed password that is stored in database.
                    if(password_verify($user['password'], $userInfo->password) && $user['csrf_code'] == $_SESSION['token']) { // csrf verification
                        $this->loadModel('Cookie');

                        setcookie('cookieuser', $_SESSION['token'], time()+600, '/', "", null, true);
                        $cookieInfo = $this->Cookie->newEntity();
                        $cookieInfo->cookieuser = strval($_SESSION['token']);
                        $cookieInfo->user_id = $userInfo->id;
                        $cookieInfo->logged_in = true;
                        $cookieInfo->login_expire = time()+600;
                        $this->Cookie->save($cookieInfo);
                        $this->Flash->success(__('You have logged in successfully'));
                        return $this->redirect(['controller' => 'Item', 'action' => 'index']);
                    } else {
                        $this->Flash->error(__('Please check your password once again'));
                        return $this->redirect(['controller' => 'User', 'action' => 'login']);
                    }
                } else {
                    $this->Flash->error(__('Please check your Username and Password'));
                    return $this->redirect(['controller' => 'User', 'action' => 'login']);
                }

            }
        } else {
            $this->Flash->error(__('You are logged in already'));
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

    /**
     * logout method
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        if(isset($_COOKIE['cookieuser'])) {
            setcookie("cookieuser", $_COOKIE['cookieuser'], time()+0, "/");
            session_destroy();
            $this->Flash->success(__('You have logged out successfully'));
            return $this->redirect(['controller' => 'Item', 'action' => 'index']);
        }
    }
}
