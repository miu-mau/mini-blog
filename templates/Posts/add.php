<?php
/** @var \App\Model\Entity\Post $post */
?>
<div class="posts form content">
	<?php $this->assign('title', __('Новый пост')); ?>
	<h1><?= h(__('Новый пост')) ?></h1>
	<?= $this->Form->create($post) ?>
	<fieldset>
		<?= $this->Form->control('title', ['label' => __('Заголовок')]) ?>
		<?= $this->Form->control('body', ['type' => 'textarea', 'label' => __('Текст')]) ?>
	</fieldset>
	<?= $this->Form->button(__('Сохранить')) ?>
	<?= $this->Form->end() ?>
</div>


