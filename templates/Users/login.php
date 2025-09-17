<div class="users form content">
	<h1><?= h(__('Вход')) ?></h1>
	<?= $this->Form->create() ?>
	<?= $this->Form->control('username', ['label' => __('Логин')]) ?>
	<?= $this->Form->control('password', ['label' => __('Пароль')]) ?>
	<?= $this->Form->button(__('Войти')) ?>
	<?= $this->Form->end() ?>
	<p><?= $this->Html->link(__('Регистрация'), ['action' => 'register']) ?></p>
</div>


