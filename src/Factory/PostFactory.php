<?php

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostFactory
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function makePost(array $data): Post{
        $category = $this->entityManager->getReference(Category::class, $data['category_id']);
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setPublishedAt($data['published_at']);
        $post->setStatus($data['status']);
        $post->setCategory($category);
        $post->setDescription($data['description']);
        return $post;
    }

}
