<?php

namespace App\Service;

use App\DTO\Input\Post\StorePostInputDTO;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PostRepository         $postRepository,
        private PostFactory            $postFactory,)
    {
    }

    public function getPosts(): array
    {
        return $this->postRepository->findAll();
    }

    public function store(StorePostInputDTO $storePostInputDTO): Post
    {
        $post = $this->postFactory->makePost($storePostInputDTO); // в репозиторий может попасть только Entity,
        // поэтому делаем на фабрике пост
        $this->postRepository->store($post); // в репозиторий может попасть только Entity
        //    $this->entityManager->persist($post);
        //    $this->entityManager->flush();
        return $post;
    }
}
