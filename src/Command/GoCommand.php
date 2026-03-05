<?php

namespace App\Command;

use App\DTOValidator\PostDTOValidator;
use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Event\Post\PostCreatedEvent;
use App\Factory\PostFactory;
use App\Factory\StorePostInputDTOFactory;
use App\Resource\PostResource;
use App\ResponseBuilder\PostResponseBuilder;
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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
        private PostDTOValidator $postDTOValidator,
        private readonly PostResource $postResource,
        private PostResponseBuilder $postResponseBuilder,
        private PostFactory $postFactory,
        private StorePostInputDTOFactory $storePostInputDTOFactory,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $post = $this->em->getRepository(Post::class)->findOneBy(['title'=>'title12']);
        $post->setDescription('ertetrert999991');
        $this->em->persist($post);
        $this->em->flush();
        $this->eventDispatcher->dispatch(new PostCreatedEvent($post), PostCreatedEvent::NAME);
        $data = [
            'title' => '12',
            'content' => 'content1',
            'description' => 'description1',
            'published_at' => '2025-12-20',
            'status' => 2,
            'category_id' => 1,
        ];
        // обрабатываем Request
        // мы делаем это для того что бы конкретно нужный атрибутивный состав валидировать и сохранять
     //   $post = $this->postFactory->makeStorePostInputDTO($data);
        $storePostInputDTO = $this->storePostInputDTOFactory->makeStorePostInputDTO($data); // фабрика один

        $this->postDTOValidator->validate($storePostInputDTO); // по конвенции валидатор может принимать только DTO

        // какая-то бизнес логика
        $post = $this->postService->store($storePostInputDTO);

     //   $post = $this->postResource->postItem($post);
        // вернули ответ
        $res = $this->postResponseBuilder->storePostResponseBuilder($post); // и тут может быть DTO
        dd($res);

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
