<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    public function __construct(private EntityManagerInterface   $entityManager,
                                private JWTTokenManagerInterface $JWTTokenManager)

    {
    }

    #[Route('api/auth/register', name: 'auth_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
//        return $this->render('auth/index.html.twig', [
//            'controller_name' => 'AuthController',
//        ]);
        return $this->json(['user' => $user, 'token' => $this->JWTTokenManager->create($user)]);
    }
    #[Route('api/auth/me', name: 'auth_me', methods: ['POST'])]
    public function me(): JsonResponse
    {
        $user = $this->getUser();
        return $this->json(['user' => $user]);
    }
}
