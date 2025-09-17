<?php
/** @var \App\Model\Entity\Post $post */
?>
<div class="posts view content">
	<?php $this->assign('title', h($post->title)); ?>
	<h1><?= h($post->title) ?></h1>
	<p><em><?= __('Автор') ?>: <?= h($post->user->username ?? '-') ?> · <?= h($post->created) ?></em></p>
	<div class="text">
		<?= nl2br(h($post->body)) ?>
	</div>
	<div class="actions">
		<?php $authUserId = (int)$this->request->getSession()->read('Auth.user_id'); ?>
		<?php if ($authUserId && (int)($post->user_id ?? 0) === $authUserId): ?>
			<?= $this->Html->link(__('Редактировать'), '/posts/edit/' . $post->id) ?>
			<?= $this->Form->postLink(__('Удалить'), ['action' => 'delete', $post->id], ['confirm' => __('Удалить пост?')]) ?>
		<?php endif; ?>
		<?= $this->Html->link(__('К списку'), '/posts') ?>
	</div>
</div>
