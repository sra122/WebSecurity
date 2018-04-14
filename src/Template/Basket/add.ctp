<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Basket $basket
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Basket'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Item'), ['controller' => 'Item', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Item', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="basket form large-9 medium-8 columns content">
    <?= $this->Form->create($basket) ?>
    <fieldset>
        <legend><?= __('Add Basket') ?></legend>
        <?php
            echo $this->Form->control('cookieuser');
            echo $this->Form->control('item_id', ['options' => $item]);
            echo $this->Form->control('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
