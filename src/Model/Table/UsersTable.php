<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('username')
            ->requirePresence('username', 'create')
            ->notEmptyString('username', __('Введите логин'))
            ->maxLength('username', 180);

        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->notEmptyString('password', __('Введите пароль'))
            ->minLength('password', 6, __('Минимум 6 символов'));

        return $validator;
    }
}


