<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

class PostsController extends AppController
{
    public function index()
    {
        $q = (string)$this->request->getQuery('q', '');
        $query = $this->Posts->find('all')
            ->contain(['Users'])
            ->order(['Posts.created' => 'DESC']);
        if ($q !== '') {
            $query = $this->Posts->find('search', ['q' => $q])
                ->contain(['Users'])
                ->order(['Posts.created' => 'DESC']);
        }
        $this->paginate = [
            'limit' => 5,
        ];
        $posts = $this->paginate($query);
        $this->set(compact('posts', 'q'));
    }

    public function view($id = null)
    {
        \Cake\Log\Log::debug('View action: id=' . var_export($id, true));
        try {
            $post = $this->Posts->get((int)$id, ['contain' => ['Users']]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            \Cake\Log\Log::warning('View not found for id=' . var_export($id, true));
            $this->Flash->error(__('Пост не найден'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('post'));
    }

    public function add()
    {
        $post = $this->Posts->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $post = $this->Posts->patchEntity($post, $data);
            // Присваиваем владельца напрямую (mass-assign запрещен)
            $post->user_id = (int)$this->request->getSession()->read('Auth.user_id');
            if (!$post->getErrors() && $this->Posts->save($post)) {
                // Страховка: если по какой-то причине user_id не сохранился, проставим напрямую
                if (!(int)($post->user_id ?? 0)) {
                    $currentUserId = (int)$this->request->getSession()->read('Auth.user_id');
                    if ($currentUserId) {
                        $this->Posts->updateAll(['user_id' => $currentUserId], ['id' => $post->id]);
                    }
                }
                $this->Flash->success(__('Пост создан'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Не удалось сохранить пост'));
        }
        $this->set(compact('post'));
    }

    public function edit($id = null)
    {
        // Allow only safe methods for edit action
        $this->request->allowMethod(['get', 'patch', 'post', 'put']);
        // Fallback to id from request data if route param missing
        if ($id === null) {
            $routeId = $this->request->getParam('id');
            if ($routeId !== null) {
                $id = (int)$routeId;
            } else {
                $pass = (array)$this->request->getParam('pass', []);
                if (isset($pass[0])) {
                    $id = (int)$pass[0];
                } else {
                    $dataId = $this->request->getData('id');
                    if ($dataId !== null) {
                        $id = (int)$dataId;
                    }
                }
            }
        }
        // Log method, target and id for diagnostics
        \Cake\Log\Log::debug('Edit action: method=' . $this->request->getMethod() . ' target=' . $this->request->getRequestTarget() . ' id=' . var_export($id, true));
        try {
            $post = $this->Posts->get((int)$id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Пост не найден'));
            return $this->redirect(['action' => 'index']);
        }
        // Разрешаем редактирование только владельцу поста
        $currentUserId = (int)$this->request->getSession()->read('Auth.user_id');
        if (!$currentUserId) {
            $this->Flash->error(__('Необходимо войти'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        // Если пост ещё без владельца, присвоим текущего пользователя (починка старых записей)
        if (!(int)($post->user_id ?? 0)) {
            $post->user_id = $currentUserId;
            $this->Posts->save($post);
        }
        if ($post->user_id !== $currentUserId) {
            $this->Flash->error(__('У вас нет прав для редактирования этого поста'));
            return $this->redirect(['action' => 'view', $post->id]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            \Cake\Log\Log::debug('Edit submit data=' . json_encode($data, JSON_UNESCAPED_UNICODE));
            $post = $this->Posts->patchEntity($post, $data);
            if (!$post->getErrors() && $this->Posts->save($post)) {
                $this->Flash->success(__('Пост обновлен'));
                \Cake\Log\Log::debug('Redirecting to view after update id=' . $post->id);
                return $this->redirect('/posts/view/' . $post->id);
            }
            if ($post->getErrors()) {
                \Cake\Log\Log::warning('Edit validation errors=' . json_encode($post->getErrors(), JSON_UNESCAPED_UNICODE));
            } else {
                \Cake\Log\Log::warning('Edit save failed without validation errors for id=' . $post->id);
            }
            $this->Flash->error(__('Не удалось обновить пост'));
        }
        $this->set(compact('post'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $post = $this->Posts->get((int)$id);
            // Разрешаем удаление только владельцу поста
            $currentUserId = (int)$this->request->getSession()->read('Auth.user_id');
            if (!$currentUserId || $post->user_id !== $currentUserId) {
                $this->Flash->error(__('У вас нет прав для удаления этого поста'));
                return $this->redirect(['action' => 'view', $post->id]);
            }
            if ($this->Posts->delete($post)) {
                $this->Flash->success(__('Пост удален'));
            } else {
                $this->Flash->error(__('Не удалось удалить пост'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Пост не найден'));
        }
        return $this->redirect(['action' => 'index']);
    }
}


