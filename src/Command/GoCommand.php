<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'go',
    description: 'Add a short description for your command',
)]
class GoCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //$post = $this->postRepository->find(1);
        $data = [
            'title' => 'title1',
            'content' => 'content1',
            'description' => 'description1',
            'published_at' => new \DateTimeImmutable('2025-12-20'),
            'status' => 2,
            'category_id' => 1,
        ];
        $category = $this->em->getRepository(Category::class)->find($data['category_id']);
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setPublishedAt($data['published_at']);
        $post->setStatus($data['status']);
        $post->setCategory($category);
        $post->setDescription($data['description']);

        $this->em->persist($post);
        $this->em->flush();
        dd($post);
        return Command::SUCCESS;
    }
}
