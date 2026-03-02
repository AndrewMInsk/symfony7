<?php

namespace App\Factory;

use App\DTO\Input\Post\StorePostInputDTO;
use Doctrine\ORM\EntityManagerInterface;

class StorePostInputDTOFactory
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function makeStorePostInputDTO(array $data): StorePostInputDTO
    {
        //  $category = $this->entityManager->getReference(Category::class, $data['category_id']);
        $post = new StorePostInputDTO();
        $post->title = $data['title'] ?? null;
        $post->content = $data['content'] ?? null;
        $post->publishedAt = new \DateTimeImmutable($data['published_at']) ?? null;
        $post->status = $data['status'] ?? null;
        $post->categoryId = $data['category_id'] ?? null;;
        $post->description = $data['description'] ?? null;
        return $post;
    }
}
