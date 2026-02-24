<?php

namespace App\Factory;

use App\DTO\Input\StorePostInputDTO;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class StorePostInputDTOFactory
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public function makeStorePostInputDTO(array $data): StorePostInputDTO{
      //  $category = $this->entityManager->getReference(Category::class, $data['category_id']);
        $post = new StorePostInputDTO();
        $post->title =$data['title'];
        $post->content =$data['content'];
        $post->publishedAt =$data['published_at'];
        $post->status =$data['status'];
        $post->categoryId =$data['category_id'];;
        $post->description =$data['description'];
        return $post;
    }
}
