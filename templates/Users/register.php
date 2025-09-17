<div class="users form content">
	<h1><?= h(__('Регистрация')) ?></h1>
	<?= $this->Form->create($user) ?>
	<?= $this->Form->control('username', ['label' => __('Логин')]) ?>
	<?= $this->Form->control('password', ['label' => __('Пароль')]) ?>
	<?= $this->Form->button(__('Создать аккаунт')) ?>
	<?= $this->Form->end() ?>
	<p><?= $this->Html->link(__('Войти'), ['action' => 'login']) ?></p>
</div>


