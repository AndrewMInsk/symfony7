<?php

namespace App\Resource;

use App\DTO\Output\Post\PostOutputDTO;
use App\Entity\Post;
use App\Service\PostService;
use Symfony\Component\Serializer\SerializerInterface;

class PostResource
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function postItem(PostOutputDTO $post){
        return $this->serializer->serialize($post, 'json', ['groups' => ['post:item']]);

    }

}
