<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) // Injection du service de hachage de mot de passe en utilisant l'interface 
  {
  }
    private const NB_ARTICLES = 15;
    private const CATEGORIES = ["Histoires de voyageurs","Inspirations de voyage","Culture et patrimoine","Aventure et plein air", "En solo", "Budget et finances", "Voyager de manière durable"];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(locale:'fr_FR');

        $categories = [];

        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < self::NB_ARTICLES; $i++) 
        {
            $article = new Article();
            $article
                ->setName($faker->words($faker->numberBetween(15, 25), true))
                ->setContent($faker->realTextBetween(1200, 2500))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 years')))
                ->setVisible($faker->boolean(90))
                ->setCategory($faker->randomElement($categories)) //Obligatoire pour ajouter un ID aléatoire dans ma table 
                ->setImageUrl($faker->imageUrl(640, 480, true, 'travel'));

            $manager->persist($article);
        }

        $ordinaryUser = new User();
        $ordinaryUser
          ->setEmail('testordinaryuser@illay.com')
          ->setPassword($this->hasher->hashPassword($ordinaryUser, 'ordinary'));
      
        $manager->persist($ordinaryUser);
      
        $adminUser = new User();
        $adminUser
          ->setEmail('admin@illay.com')
          ->setRoles(['ROLE_ADMIN'])
          ->setPassword($this->hasher->hashPassword($adminUser, 'admin'));
      
        $manager->persist($adminUser);

        $manager->flush();
    }
}
