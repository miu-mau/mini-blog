<?php
use Migrations\AbstractMigration;

class CreateUsersAndPosts extends AbstractMigration
{
    public function change(): void
    {
        if (!$this->hasTable('users')) {
            $this->table('users')
                ->addColumn('username', 'string', ['limit' => 180, 'null' => false])
                ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
                ->addTimestamps()
                ->create();
        }

        if (!$this->hasTable('posts')) {
            $this->table('posts')
                ->addColumn('user_id', 'integer', ['null' => true])
                ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
                ->addColumn('body', 'text', ['null' => false])
                ->addTimestamps()
                ->addIndex(['user_id'])
                ->create();
        }
    }

}
