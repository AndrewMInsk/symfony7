<?php

namespace App\DTO\Input;

use App\Entity\Category;
use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;

class StorePostInputDTO
{


    #[Assert\NotBlank(allowNull: null, normalizer: 'trim', message: 'bla bla bla')]
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
    public ?int $categoryId = null;

    public function storePostDTO(array $data)
    {

    }

}
