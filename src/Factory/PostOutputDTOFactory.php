<?php

namespace App\Factory;

use App\DTO\Input\Post\StorePostInputDTO;
use App\DTO\Output\Post\PostOutputDTO;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostOutputDTOFactory
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function makePostOutputDTO(Post $post): PostOutputDTO{
      //  $category = $this->entityManager->getReference(Category::class, $data['category_id']);
        $postOutput = new PostOutputDTO();
        $postOutput->title =$post->getTitle();
        $postOutput->content =$post->getContent();
        $postOutput->publishedAt =$post->getPublishedAt();
        $postOutput->status =$post->getStatus();
        $postOutput->category =$post->getCategory();
        $postOutput->description =$post->getDescription();
        return $postOutput;
    }
}
