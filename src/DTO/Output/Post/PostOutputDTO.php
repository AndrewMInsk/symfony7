<?php

namespace App\DTO\Output\Post;

use App\Entity\Category;
use App\Entity\Tag;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

class PostOutputDTO
{

    #[Groups(groups: ['post:item', 'post:list'])]
    public ?int $id = null;
    #[Groups(groups: ['post:item'])]
    public ?string $title = null;
    #[Groups(groups: ['post:item'])]
    public ?string $description = null;
    #[Groups(groups: ['post:item'])]
    public ?string $content = null;
    #[Groups(groups: ['post:item'])]
    public ?\DateTimeImmutable $publishedAt = null;
    #[Groups(groups: ['post:item'])]
    public ?int $status = 1;
    #[Groups(groups: ['post:item'])]
    public ?Category $category = null;
    #[Groups(groups: ['post:item'])]
    public Collection $tags;

    public function storePostDTO(array $data)
    {

    }

}
