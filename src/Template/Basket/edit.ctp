<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Basket $basket
 */
?>
<div class="basket form columns content">
    <?= $this->Form->create($basket, ['type' => 'put']) ?>
    <fieldset>
        <legend><?= __('Edit Basket') ?></legend>
        <?php
            echo $this->Form->control('item', ['type' => 'text', 'escape' => false, 'value' => $basket->item->name, 'disabled' => true]);
            echo $this->Form->control('price', [ 'type' => 'text']);
            echo $this->Form->select('quantity', [1 => '1',
                                                                     2 => '2',
                                                                     3 => '3',
                                                                     4 => '4',
                                                                     5 => '5'], ['class' => 'quantity_dropdown']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
