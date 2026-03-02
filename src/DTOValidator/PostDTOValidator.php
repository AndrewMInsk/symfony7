<?php

namespace App\DTOValidator;

use App\DTO\Input\Post\StorePostInputDTO;
use App\DTO\Input\Post\UpdatePostInputDTO;
use App\Exception\ValidateException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostDTOValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(StorePostInputDTO|UpdatePostInputDTO $post)
    {
        $errors = $this->validator->validate($post);
        $messages = [];
        if (count($errors) > 0) {

            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
          //  return new JsonResponse($messages, 422);
            throw new ValidateException($messages);
        }
    }
}
