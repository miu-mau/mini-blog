<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{
    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['password'] = password_hash((string)($data['password'] ?? ''), PASSWORD_DEFAULT);
            $user = $this->Users->patchEntity($user, $data);
            if (!$user->getErrors() && $this->Users->save($user)) {
                $this->Flash->success(__('Регистрация успешна. Теперь войдите.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Не удалось зарегистрироваться'));
        }
        $this->set(compact('user'));
    }

    public function login()
    {
        // If already logged in, go to posts
        if ($this->request->getSession()->read('Auth.user_id')) {
            return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $username = (string)$this->request->getData('username');
            $password = (string)$this->request->getData('password');

            $user = $this->Users->find()->where(['username' => $username])->first();
            if ($user) {
                if (password_verify($password, (string)$user->password)) {
                    $this->request->getSession()->write('Auth.user_id', $user->id);
                    $this->request->getSession()->write('Auth.username', $user->username);
                    $this->Flash->success(__('Вы вошли'));
                    return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('Неверный логин или пароль'));
        }
    }

    public function logout()
    {
        $this->request->getSession()->destroy();
        $this->Flash->success(__('Вы вышли'));
        return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
    }
}


