<?php

namespace App\Validator\Constraint;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityExistsValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        $category = $this->entityManager->getRepository($constraint->entity)->find($value);
        if(!$category){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ id }}', $value)
                ->setParameter('{{ entity }}', $constraint->entity)
                ->addViolation();
        }
    }
}
