<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>

<div style="height: 50px;"></div>

<div class="uk-container">
    <div class="uk-child-width-1-2 uk-text-center" uk-grid>
        <div>
            <div><?= $this->Html->image($item->imageUrl, ['alt' => 'CakePHP']); ?></div>
        </div>
        <div>
            <div class="uk-child-width-1-1" uk-grid>
                <div>
                    <div><h1><?= ($item->name) ?><h1></div>
                    <div class="uk-child-width-1-2" uk-grid>
                        <div>Price</div>
                        <div><?= $item->price?>€</div>
                    </div>
                    <div class="uk-child-width-1-2" uk-grid>
                        <div>Item Description</div>
                        <div><?= $item->description ?></div>
                    </div>
                    <?= $this->Form->create(null, ['url' => ['controller' => 'Basket', 'action' => 'addcart', $item->id]]); ?>
                    <div style="height: 30px;"></div>
                    <div class="uk-child-width-1-2" uk-grid>
                        <div>Quantity</div>
                        <div><?= $this->Form->select('quantity', [1 => '1',
                                                                     2 => '2',
                                                                     3 => '3',
                                                                     4 => '4',
                                                                     5 => '5'], ['class' => 'quantity_dropdown']); ?></div>
                    </div>
                    <div style="height: 50px;"></div>
                    <div><?= $this->Form->button('Add to Cart', ['type' => 'submit'], ['class' => 'uk-button uk-button-primary']) ?></div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>