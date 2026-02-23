<?php

namespace App\Validator;

use App\Entity\Post;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(Post $post): void{
        $errors = $this->validator->validate($post);
        $messages = [];
        if(count($errors) > 0){

            foreach($errors as $error){
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
            throw new \InvalidArgumentException(json_encode($messages));
        }
    }
}
