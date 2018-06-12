
<div style="height: 50px;"></div>

<div class="uk-container">
    <div class="uk-child-width-1-2@m uk-grid-small uk-grid-match" uk-grid>
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">Hello <?= $user_details->user->firstname ?> <?= $user_details->user->lastname ?></h3>
                <h3>Delivery Address:</h3>
                <p><?= $user_details->user->address ?></p>
                <?= $this->Html->link(__('Edit'), ['action' => 'deliveryAddressEdit', $user_details->user->id]) ?>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">Credit Card Details</h3>
                <p><?= $user_details->user->credit_card ?></p>
                <?= $this->Html->link(__('Edit'), ['action' => 'creditCardEdit', $user_details->user->id]) ?>
            </div>
        </div>
    </div>
    <br><br>
    <?= $this->Html->link('Confirm', ['controller' => 'Orders', 'action' => 'checkout'], ['class' => 'uk-flex uk-flex-center']) ?>
</div>