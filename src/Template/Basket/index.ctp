<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Basket[]|\Cake\Collection\CollectionInterface $basket
 */
?>
<div class="basket index large-9 medium-8 columns content">
    <h3><?= __('Basket') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($basket as $basket): ?>
            <tr>
                <td><?php echo $this->Html->image($basket->item->imageUrl, ['alt' => 'CakePHP','class' => 'basket_image']); ?>&nbsp;<?= $basket->has('item') ? $this->Html->link($basket->item->name, ['controller' => 'Item', 'action' => 'view', $basket->item->id]) : '' ?></td>
                <td><?= $this->Number->format($basket->price) ?>€</td>
                <td><?= $basket->quantity ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $basket->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $basket->id], ['confirm' => __('Are you sure you want to delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->Html->link('Checkout', ['controller' => 'Orders', 'action' => 'deliveryAddress']) ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
