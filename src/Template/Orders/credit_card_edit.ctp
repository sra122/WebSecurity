<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 */
?>
<div class="user form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit Credit Card') ?></legend>
        <?php
        echo $this->Form->control('credit_card', ['required' => false]);
        ?>
        <input type="hidden" name="csrf_code" value=<?= $_SESSION['token'] ?>>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
