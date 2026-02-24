<?php

namespace App\Service;

use App\DTO\Input\StorePostInputDTO;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PostService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PostRepository         $postRepository,
        private PostFactory            $postFactory,)
    {
    }

    public function store(StorePostInputDTO $storePostInputDTO): Post
    {
        $post = $this->postFactory->makePost($storePostInputDTO); // в репозиторий может попасть только Entity,
        // поэтому делаем на фабрике пост
        $this->postRepository->store($post);
        //    $this->entityManager->persist($post);
        //    $this->entityManager->flush();
        return $post;
    }
}
