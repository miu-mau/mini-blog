<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\Database\Schema\SqlGeneratorInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PostsTable extends Table
{
    public static function defaultConnectionName(): string
    {
        return 'default';
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->notEmptyString('title', __('Заголовок обязателен'))
            ->maxLength('title', 255);

        $validator
            ->scalar('body')
            ->requirePresence('body', 'create')
            ->notEmptyString('body', __('Текст обязателен'));

        return $validator;
    }

    public function findSearch(SelectQuery $query, array $options): SelectQuery
    {
        $q = trim((string)($options['q'] ?? ''));
        if ($q === '') {
            return $query;
        }
        return $query->where([
            'OR' => [
                'title LIKE' => "%$q%",
                'body LIKE' => "%$q%",
            ],
        ]);
    }
}


