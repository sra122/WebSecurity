<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Basket $basket
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Basket'), ['action' => 'edit', $basket->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Basket'), ['action' => 'delete', $basket->id], ['confirm' => __('Are you sure you want to delete # {0}?', $basket->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Basket'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Basket'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item'), ['controller' => 'Item', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Item', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="basket view large-9 medium-8 columns content">
    <h3><?= h($basket->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cookieuser') ?></th>
            <td><?= h($basket->cookieuser) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $basket->has('item') ? $this->Html->link($basket->item->name, ['controller' => 'Item', 'action' => 'view', $basket->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($basket->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($basket->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($basket->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($basket->modified) ?></td>
        </tr>
    </table>
</div>
