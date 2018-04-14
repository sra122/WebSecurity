<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $item
 */
?>

<div style="height: 50px;"></div>
<div class="uk-container">
    <div class="uk-text-center uk-child-width-1-3@m uk-grid-large uk-grid-match" uk-grid>
        <?php foreach ($item as $item): ?>
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <div class="row">
                    <div><?= h($item->name) ?></div>
                    <div class="item_container"><?php echo $this->Html->image($item->imageUrl, ['alt' => 'CakePHP', 'class' => 'item_image']); ?></div>
                    <p><?= $item->description ?></p>
                    <?= $this->Html->link('View Item', ['action' => 'view' ,$item->id]) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>