<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Post extends Entity
{
    protected array $_accessible = [
        'title' => true,
        'body' => true,
        'created' => true,
        'modified' => true,
        // user_id только из кода контроллера, не через формы
        'user_id' => false,
        'user' => true,
    ];
}


