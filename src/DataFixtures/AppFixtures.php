<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Transport;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;
use Faker\Factory;
use Symfony\Component\Messenger\Command\SetupTransportsCommand;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) // Injection du service de hachage de mot de passe en utilisant l'interface 
  {
  }
    private const NB_ARTICLES = 10;
    private const CATEGORIES = ["Histoires de voyageurs","Inspirations de voyage","Culture et patrimoine","Aventure et plein air", "En solo", "Budget et finances", "Voyager de manière durable"];
    private const TRANSPORTS = ["Avion", "Voiture", "Bateau", "Vélo"];
    private const AUTHORS = ["Lucas", "Emma"];

    private const EMISSION_FACTORS = [
      'Avion' => 255,
      'Voiture' => 180,
      'Bateau' => 200,
      'Vélo' => 0];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(locale:'fr_FR');

        $categories = [];
        $transports = [];
        $authors = [];

        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $categories[] = $category;
        }

        foreach (self::TRANSPORTS as $transportName) {
          $transport = new Transport();
          $transport
              ->setName($transportName)
              ->setEmissionFactor(self::EMISSION_FACTORS[$transportName]);

          $manager->persist($transport);
          $transports[] = $transport;
      }

      foreach (self::AUTHORS as $authorName) {
        $author = new Author();
        $author->setName($authorName);

        $manager->persist($author);
        $authors[] = $author;
    }

      $ordinaryUser = new User();
        $ordinaryUser
          ->setEmail('testordinaryuser@illay.com')
          ->setPassword($this->hasher->hashPassword($ordinaryUser, 'ordinary'));
      
        $manager->persist($ordinaryUser);
      
        $adminUser1 = new User();
        $adminUser1
          ->setEmail('admin1@illay.com')
          ->setRoles(['ROLE_ADMIN'])
          ->setPassword($this->hasher->hashPassword($adminUser1, 'admin'));
          $manager->persist($adminUser1);
          $adminUsers[] = $adminUser1;
      
        $adminUser2 = new User();
        $adminUser2
          ->setEmail('admin2@illay.com')
          ->setRoles(['ROLE_ADMIN'])
          ->setPassword($this->hasher->hashPassword($adminUser2, 'admin'));
          $manager->persist($adminUser2);
          $adminUsers[] = $adminUser2;
      
        for ($i = 0; $i < self::NB_ARTICLES; $i++) 
        {
            $article = new Article();
            $article
                ->setName($faker->words($faker->numberBetween(15, 17), true))
                ->setContent($faker->realTextBetween(300, 700))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 years')))
                ->setVisible($faker->boolean(90))
                ->setCategory($faker->randomElement($categories)) //Obligatoire pour ajouter un ID aléatoire dans ma table 
                ->setImageUrl('image' . ($i % 9) . '.jpg') // Chemin de l'image
                ->setTransport($faker->randomElement($transports))
                ->setDistance($faker->randomFloat(2, 10, 10000))
                ->setAuthor($faker->randomElement($authors));

            $manager->persist($article);
        }

        $manager->flush();
    }
}