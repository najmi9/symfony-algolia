<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       for ($i = 0; $i < 100; $i++) {
           $product = new Product();

           $product->setName('name'.$i)
               ->setDescription('description'.$i)
               ->setPrice(mt_rand(14, 5987))
               ->setIsEnabled(true)
               ->setCreatedAt(new \DateTime())
               ;
           $manager->persist($product);
       }

        $manager->flush();
    }
}
