<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        $user = $this->getUser();
        
        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        return new JsonResponse([
            'success' => true,
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'nomUtilisateur' => $user->getNomUtilisateur(),
            ]
        ]);
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['email'], $data['nomUtilisateur'], $data['password'])) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Missing required fields'
            ], 400);
        }

        $user = new Utilisateur();
        $user->setEmail($data['email']);
        $user->setNomUtilisateur($data['nomUtilisateur']);

        // Hash the password
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setMotDePasseHache($hashedPassword);

        // Validate the user
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $errorMessages
            ], 400);
        }

        try {
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'User created successfully',
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'nomUtilisateur' => $user->getNomUtilisateur(),
                ]
            ], 201);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ], 500);
        }
    }

    #[Route('/user/themes', name: 'user_themes', methods: ['GET'])]
    public function getUserThemes(): JsonResponse
    {
        $user = $this->getUser();
        
        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $themes = [];
        foreach ($user->getThemes() as $theme) {
            $themes[] = [
                'id' => $theme->getId(),
                'nomTheme' => $theme->getNomTheme(),
                'descriptionTheme' => $theme->getDescriptionTheme(),
            ];
        }

        return new JsonResponse([
            'success' => true,
            'themes' => $themes
        ]);
    }
}