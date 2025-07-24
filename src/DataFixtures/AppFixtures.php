<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use App\Entity\Utilisateur;
use App\Entity\Exercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create Sport theme
        $sportTheme = new Theme();
        $sportTheme->setNomTheme('Sport');
        $sportTheme->setDescriptionTheme('Thème dédié à la gestion des programmes d\'entraînement, séances et exercices');
        $manager->persist($sportTheme);

        // Create demo user
        $user = new Utilisateur();
        $user->setNomUtilisateur('demo');
        $user->setEmail('demo@bastien-webapp.fr');
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'demo123');
        $user->setMotDePasseHache($hashedPassword);
        
        // Give user access to Sport theme
        $user->addTheme($sportTheme);
        
        $manager->persist($user);

        // Create some sample exercises
        $exercises = [
            ['Pompes', 'Exercice au poids du corps pour les pectoraux et triceps', 'force'],
            ['Course à pied', 'Exercice cardiovasculaire de base', 'cardio'],
            ['Squats', 'Exercice pour les jambes et fessiers', 'force'],
            ['Planche', 'Exercice de gainage pour les abdominaux', 'force'],
            ['Burpees', 'Exercice complet alliant cardio et force', 'cardio'],
            ['Étirements', 'Exercices pour améliorer la flexibilité', 'flexibilite'],
            ['Vélo', 'Exercice cardiovasculaire sur vélo', 'cardio'],
            ['Tractions', 'Exercice pour le dos et les biceps', 'force']
        ];

        foreach ($exercises as [$nom, $description, $type]) {
            $exercice = new Exercice();
            $exercice->setNomExercice($nom);
            $exercice->setDescriptionExercice($description);
            $exercice->setTypeExercice($type);
            $manager->persist($exercice);
        }

        $manager->flush();
    }
}