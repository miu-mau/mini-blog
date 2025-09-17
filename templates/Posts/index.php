<?php
/** @var \App\View\AppView $this */
/** @var \Cake\Datasource\ResultSetInterface|\App\Model\Entity\Post[] $posts */
?>
<div class="posts index content">
	<?php $this->assign('title', __('Блог')); ?>
	<h1><?= h(__('Блог')) ?></h1>
	<div class="actions">
		<?php if ($this->request->getSession()->read('Auth.user_id')): ?>
			<?= $this->Html->link(__('Новый пост'), ['action' => 'add'], ['class' => 'button float-right']) ?>
		<?php endif; ?>
	</div>
	<div class="search">
		<?= $this->Form->create(null, ['type' => 'get']) ?>
		<?= $this->Form->control('q', ['label' => false, 'value' => $q ?? '', 'placeholder' => __('Поиск по блогу...')]) ?>
		<?= $this->Form->button(__('Искать')) ?>
		<?= $this->Form->end() ?>
	</div>
	<table>
		<thead>
			<tr>
				<th><?= __('Заголовок') ?></th>
				<th><?= __('Автор') ?></th>
				<th><?= __('Создан') ?></th>
				<th class="actions"><?= __('Действия') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $post): ?>
			<tr>
				<td><?= $this->Html->link(h($post->title), '/posts/view/' . $post->id) ?></td>
				<td><?= h($post->user->username ?? '-') ?></td>
				<td><?= h($post->created) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('Просмотр'), '/posts/view/' . $post->id) ?>
					<?php $authUserId = (int)$this->request->getSession()->read('Auth.user_id'); ?>
					<?php if ($authUserId && (int)($post->user_id ?? 0) === $authUserId): ?>
					<?= $this->Html->link(__('Редактировать'), '/posts/edit/' . $post->id) ?>
						<?= $this->Form->postLink(__('Удалить'), '/posts/delete/' . $post->id, ['confirm' => __('Удалить пост #{0}?', $post->id)]) ?>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->first('<< ' . __('первая')) ?>
			<?= $this->Paginator->prev('< ' . __('назад')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('вперёд') . ' >') ?>
			<?= $this->Paginator->last(__('последняя') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(__('Страница {{page}} из {{pages}}, показано {{current}} из {{count}}')) ?></p>
	</div>
</div>
