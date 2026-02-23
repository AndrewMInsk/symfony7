<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PostService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PostRepository         $postRepository)
    {
    }

    public function store(Post $post): Post
    {
        $this->postRepository->store($post);
    //    $this->entityManager->persist($post);
    //    $this->entityManager->flush();
        return $post;
    }
}
