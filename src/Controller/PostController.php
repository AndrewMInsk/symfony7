<?php

namespace App\Controller;

use App\DTOValidator\PostDTOValidator;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\Factory\PostOutputDTOFactory;
use App\Factory\StorePostInputDTOFactory;
use App\Resource\PostResource;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    public function __construct(
        private PostService              $postService,
        private PostResponseBuilder      $postResponseBuilder,
        private PostDTOValidator         $postDTOValidator,
        private StorePostInputDTOFactory $storePostInputDTOFactory
    )
    {
    }

    #[Route('api/posts', name: 'posts_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $posts = $this->postService->getPosts();
        return $this->postResponseBuilder->getAllPostResponseBuilder($posts);
//        return $this->render('post/index.html.twig', [
//            'controller_name' => 'PostController',
//        ]);
    }

    #[Route('api/posts/{post}', name: 'posts_show', methods: ['GET'])]
    public function show(Post $post): JsonResponse
    {
        return $this->postResponseBuilder->getPostResponseBuilder($post);
    }

    #[Route('api/posts', name: 'posts_store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $storePostInputDTO = $this->storePostInputDTOFactory->makeStorePostInputDTO($data); // делаем DTO из массива

        $this->postDTOValidator->validate($storePostInputDTO); // по конвенции валидатор может принимать только DTO
        // // валидируем (параметры берем из аннотаций энтити)

        // какая-то бизнес логика
        $post = $this->postService->store($storePostInputDTO); // делаем там энтитю из ДТО и там сохраняем ее через репозиторий

        // вернули ответ
        return $this->postResponseBuilder->storePostResponseBuilder($post); // там сделали   DTO  и из него ресурс (там настройки групп)

        //   return $this->postResponseBuilder->getPostResponseBuilder($post);
    }
}
