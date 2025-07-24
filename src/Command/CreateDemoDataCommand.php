<?php

namespace App\Command;

use App\Entity\Theme;
use App\Entity\Utilisateur;
use App\Entity\Exercice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-demo-data',
    description: 'Create demo data for the application',
)]
class CreateDemoDataCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Create Sport theme
        $sportTheme = new Theme();
        $sportTheme->setNomTheme('Sport');
        $sportTheme->setDescriptionTheme('Theme dedie a la gestion des programmes d\'entrainement, seances et exercices');
        $this->entityManager->persist($sportTheme);

        // Create demo user
        $user = new Utilisateur();
        $user->setNomUtilisateur('demo');
        $user->setEmail('demo@bastien-webapp.fr');
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'demo123');
        $user->setMotDePasseHache($hashedPassword);
        
        // Give user access to Sport theme
        $user->addTheme($sportTheme);
        
        $this->entityManager->persist($user);

        // Create some sample exercises
        $exercises = [
            ['Pompes', 'Exercice au poids du corps pour les pectoraux et triceps', 'force'],
            ['Course a pied', 'Exercice cardiovasculaire de base', 'cardio'],
            ['Squats', 'Exercice pour les jambes et fessiers', 'force'],
            ['Planche', 'Exercice de gainage pour les abdominaux', 'force'],
            ['Burpees', 'Exercice complet alliant cardio et force', 'cardio'],
            ['Etirements', 'Exercices pour ameliorer la flexibilite', 'flexibilite'],
            ['Velo', 'Exercice cardiovasculaire sur velo', 'cardio'],
            ['Tractions', 'Exercice pour le dos et les biceps', 'force']
        ];

        foreach ($exercises as [$nom, $description, $type]) {
            $exercice = new Exercice();
            $exercice->setNomExercice($nom);
            $exercice->setDescriptionExercice($description);
            $exercice->setTypeExercice($type);
            $this->entityManager->persist($exercice);
        }

        $this->entityManager->flush();

        $output->writeln('Demo data created successfully!');
        $output->writeln('Demo user: demo@bastien-webapp.fr / demo123');

        return Command::SUCCESS;
    }
}