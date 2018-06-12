<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;


class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $totalItems = $this->getBasketValue();

        $this->set('totalItems', $totalItems);

    }

    public function getBasketValue()
    {
        if(isset($_COOKIE['cookieuser'])) {
            $this->loadModel('Cookie');
            $this->loadModel('Basket');
            $userDetails = $this->Cookie->find()->where(['cookieuser' => $_SESSION['token']])->contain(['User'])->first();
            $basketCount = $this->Basket->find()->where(['user_id' => $userDetails->user->id])->count();
            return $basketCount;
        }
    }

}
