<?php
/** @var \App\Model\Entity\Post $post */
?>
<div class="posts form content">
	<?php $this->assign('title', __('Редактирование поста')); ?>
	<h1><?= h(__('Редактирование поста')) ?></h1>
    <?= $this->Form->create($post, ['url' => '/posts/edit/' . $post->id]) ?>
    <?= $this->Form->hidden('_method', ['value' => 'PATCH']) ?>
	<fieldset>
		<?= $this->Form->control('title', ['label' => __('Заголовок')]) ?>
		<?= $this->Form->control('body', ['type' => 'textarea', 'label' => __('Текст')]) ?>
	</fieldset>
	<?= $this->Form->button(__('Сохранить')) ?>
	<?= $this->Form->end() ?>
</div>


