<div class="uk-container" style="width: 40%; margin-left: 18%;">
    <?php  echo $this->Form->create(null, 
                            ['class' => 'uk-form-horizontal uk-margin-large', 'url' => ['controller' => 'User', 'action' => 'login']]);  ?>

        <div class="uk-margin">
            <div class="uk-form-controls">
                <input class="uk-input" id="form-horizontal-text" type="text" placeholder="User name" name="username">
            </div>
        </div>

        <div class="uk-margin">
            <div class="uk-form-controls">
                <input class="uk-input" id="form-horizontal-text" type="password" placeholder="password" name="password">
                <input type="hidden" name="csrf_code" value=<?= $_SESSION['token'] ?>>
            </div>
        </div>

        <div class="uk-margin">
            <div class="uk-form-controls">
                <button class="uk-button uk-button-primary">Sign in</button>
            </div>
        </div>
    <p style="margin-left: 40%;"><?= $this->Html->link(__('Register for New User'), ['action' => 'add']) ?></p>
    <?php echo $this->Form->end(); ?>

</div>