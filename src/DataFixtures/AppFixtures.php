<?php

namespace App\DataFixtures;

use App\Article\Status;
use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();

            $category->setName($faker->word())
                ->setCreated(new DateTime());
            $manager->persist($category);
            
            for ($j=0; $j < 10; $j++) { 
                $article = new Article();

                $article->setTitle($faker->sentence())
                    ->setContent($faker->text())
                    ->setStatus($status =  $faker->numberBetween(Status::NOT_PUBLISHED, Status::PUBLISHED))
                    ->setTrending($faker->boolean())
                    ->setCreated(new DateTime())
                    ->setCategory($category);
                
                if ($status === Status::PUBLISHED) {
                    $article->setPublished(new DateTime);
                }
                else {
                    $article->setPublished(null);
                }
                $manager->persist($article);
            }
            
        }

        $manager->flush();
    }
}
