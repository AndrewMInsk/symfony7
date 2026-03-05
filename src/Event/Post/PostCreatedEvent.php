<?php

namespace App\Event\Post;

use App\Entity\Post;

class PostCreatedEvent
{
    public const NAME = 'onPostCreated';
    public function __construct(private Post $post)
    {
        dump('event from construct');
    }

    public function getPost(): Post
    {
        return $this->post;
    }

}
