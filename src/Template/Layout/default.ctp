<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('item.css') ?>
    <?= $this->Html->script('mag.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit-icons.min.js"></script>
</head>
<body>
    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="/">FH Kiel Webshop</a>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav uk-hidden-small">
                <li><?= $this->Html->link('Login', ['controller' => 'user', 'action' => 'login'], ['class' => 'uk-button uk-button-primary']) ?></li>
                <!--<li><?= $this->Html->link(
                        $this->Html->image('basket.png', ['class' => 'basket']), ['controller' => 'Basket', 'action' => 'index']) ?></li> -->
                <li class="uk-active"><a href="/basket/index"><img src="https://cdn4.iconfinder.com/data/icons/adiante-apps-app-templates-incos-in-grey/512/app_type_shop_512px_GREY.png" style="width: 100%; height: 41%;"></a></li> 
            </ul>
        </div>

    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
