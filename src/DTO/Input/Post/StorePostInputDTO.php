<?php

namespace App\DTO\Input\Post;

use App\Entity\Category;
use App\Validator\Constraint\EntityExists;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class StorePostInputDTO
{


    #[Assert\NotBlank(allowNull: null, normalizer: 'trim', message: 'error bla bla bla')]
    #[Assert\Length(min: 1, max: 20, minMessage: 'The post title is too short.')]
    public ?string $title = null;
    #[Assert\NotBlank(allowNull: true, normalizer: 'trim', message: 'bla bla bla')]
    #[Assert\Length(min: 1, max: 20, minMessage: 'The post title is too short.')]
    public ?string $description = null;
    #[Assert\NotBlank(allowNull: true, normalizer: 'trim', message: 'bla bla bla')]
    #[Assert\Length(min: 1, max: 20, minMessage: 'The post title is too short.')]
    public ?string $content = null;
    #[Assert\Type(type: DateTimeImmutable::class)]
    public ?\DateTimeImmutable $publishedAt = null;
    #[Assert\Type(type: 'integer')]
    #[Assert\NotNull]
    public ?int $status = 1;

    #[Assert\NotNull]
    #[EntityExists(entity:Category::class)]
    public ?int $categoryId = null;

    public function storePostDTO(array $data)
    {

    }

}
