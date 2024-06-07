<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 15;
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create(locale:'fr_FR');

        for ($i = 0; $i < self::NB_ARTICLES; $i++) 
        {
            $article = new Article();
            $article
                ->setCategory($faker->randomElement($categories))// Obligatoire pour ajouter un ID aléatoire dans ma table 
                ->setName($faker->words($faker->numberBetween(15, 25), true))
                ->setContent($faker->realTextBetween(1200, 2500))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 years')))
                ->setVisible($faker->boolean(90));

            $manager->persist($article);
        }
            $manager->flush();
    }
}
