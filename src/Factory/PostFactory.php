<?php

namespace App\Factory;

use App\DTO\Input\Post\StorePostInputDTO;
use App\DTO\Input\Post\UpdatePostInputDTO;
use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostFactory
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function makePost(StorePostInputDTO $storePostInputDTO): Post{
        $category = $this->entityManager->getReference(Category::class, $storePostInputDTO->categoryId);
        $post = new Post();
        $post->setTitle($storePostInputDTO->title);
        $post->setContent($storePostInputDTO->content);
        $post->setPublishedAt($storePostInputDTO->publishedAt);
        $post->setStatus($storePostInputDTO->status);
        $post->setCategory($category);
        $post->setDescription($storePostInputDTO->description);
        return $post;
    }
    public function editPost(Post $post, UpdatePostInputDTO $updatePostInputDTO): Post{
        $category = $this->entityManager->getReference(Category::class, $updatePostInputDTO->categoryId);
        $post->setTitle($updatePostInputDTO->title);
        $post->setContent($updatePostInputDTO->content);
        $post->setPublishedAt($updatePostInputDTO->publishedAt);
        $post->setStatus($updatePostInputDTO->status);
        $post->setCategory($category);
        $post->setDescription($updatePostInputDTO->description);
        return $post;
    }

}
