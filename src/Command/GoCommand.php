<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Service\PostService;
use App\Validator\PostValidator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'go',
    description: 'Add a short description for your command',
)]
class GoCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private readonly PostService   $postService,
        private PostValidator $postValidator,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = [
            'title' => '',
            'content' => 'content1',
            'description' => 'description1',
            'published_at' => new \DateTimeImmutable('2025-12-20'),
            'status' => 2,
            'category_id' => 1,
        ];
        $category = $this->em->getReference(Category::class, $data['category_id']);
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setPublishedAt($data['published_at']);
        $post->setStatus($data['status']);
        $post->setCategory($category);
        $post->setDescription($data['description']);
        $errors = $this->postValidator->validate($post);
        dd($errors);
        $this->postService->store($post);

        return Command::SUCCESS;
    }
    /**
     * @throws ORMException
     */
    protected function executeTest(InputInterface $input, OutputInterface $output): int
    {
        //$post = $this->postRepository->find(1);
        $data = [
            'title' => 'title12',
            'content' => 'content1',
            'description' => 'description1',
            'published_at' => new \DateTimeImmutable('2025-12-20'),
            'status' => 2,
            'category_id' => 1,
        ];
        //add
        //  $category = $this->em->getRepository(Category::class)->find($data['category_id']);
        // тут прикол в том, что сама категория целиком ниже грузится не будет.
        // Но только в том случае если до этого она не была загружена
        $category = $this->em->getReference(Category::class, $data['category_id']);
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setPublishedAt($data['published_at']);
        $post->setStatus($data['status']);
        $post->setCategory($category);
        $post->setDescription($data['description']);

        // $this->em->persist($post);
        //  $this->em->flush();
        //update
        $post = $this->em->getRepository(Post::class)->find(5);
        $post->setTitle('121225552');
        $post->setContent('content2' ?? '345');
        $post->setPublishedAt($data['published_at']);
        $post->setStatus($data['status'] ?? 2);
        $post->setCategory($category);
        $post->setDescription($data['description']);
        $this->em->persist($post);
        $this->em->flush();
        //delete
        $post = $this->em->getRepository(Post::class)->find(7);
        if ($post) {
            $this->em->remove($post);
            $this->em->flush();
        }
        //add tag
        $post = $this->em->getRepository(Post::class)->find(1);
        $tag = $this->em->getRepository(Tag::class)->find(1);
        //$post->toogle($tag);
        $post->sync($tag);
        $this->em->persist($post);
        // $this->em->flush();

        dd($post);
        return Command::SUCCESS;
    }
}
