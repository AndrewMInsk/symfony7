<?php

namespace App\Listener\EventListener\Post;

use App\Event\Post\PostCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: PostCreatedEvent::NAME, method: 'someMethod', priority: 2)]
class PostCreatedListener
{
    public function someMethod(PostCreatedEvent $event): void
    {
        dump('Custom event from listener');
       // dd($event->getPost());
    }
}
