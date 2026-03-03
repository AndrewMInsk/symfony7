<?php

namespace App\ResponseBuilder;

use App\Entity\Post;
use App\Factory\PostOutputDTOFactory;
use App\Resource\PostResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostResponseBuilder
{
    public function __construct(private PostResource $postResource, private PostOutputDTOFactory $postOutputDTOFactory)
    {
    }

    public function storePostResponseBuilder(Post $post, $status = 200, $headers = [], $isJson = true): JsonResponse
    {
        $postOutputDTO = $this->postOutputDTOFactory->makePostOutputDTO($post);
        $postResource = $this->postResource->postItem($postOutputDTO);
        return new JsonResponse($postResource, $status, $headers = [], $isJson);
    }
    public function updatePostResponseBuilder(Post $post, $status = 200, $headers = [], $isJson = true): JsonResponse
    {
        $postOutputDTO = $this->postOutputDTOFactory->makePostOutputDTO($post);
        $postResource = $this->postResource->postItem($postOutputDTO);
        return new JsonResponse($postResource, $status, $headers = [], $isJson);
    }
    public function getAllPostResponseBuilder(array $posts, $status = 200, $headers = [], $isJson = false): JsonResponse
    {
        $postOutputDTOs = $this->postOutputDTOFactory->makePostsOutputDTOs($posts);
        $postResource = $this->postResource->postCollection($postOutputDTOs);
        return new JsonResponse(['data'=>$postResource], $status, $headers = [], $isJson);
    }
    public function getPostResponseBuilder($post, $status = 200, $headers = [], $isJson = false): JsonResponse
    {
        $postOutputDTO = $this->postOutputDTOFactory->makePostOutputDTO($post);
        $postResource = $this->postResource->postItem($postOutputDTO);
        return new JsonResponse(['data'=>$postResource], $status, $headers = [], $isJson);
    }
    public function destroyPostResponseBuilder($status = 200, $headers = [], $isJson = false): JsonResponse
    {
        return new JsonResponse(['message'=>'destroy'], $status, $headers = [], $isJson);
    }
}
