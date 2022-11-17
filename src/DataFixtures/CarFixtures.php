<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $name = ['toyota', 'range rover','peugeo','suzuki','yamaha','mercedes','carina'];
        $type = ['bus', 'course','4X4'];
        $dis=[true,false];
        
for ($i=0; $i <100 ; $i++) { 
    $car = new Car();
   $carCategory = new CarCategory();
   $carCategory->setNameCategory($type[array_rand($type)]);
$car->setName($name[array_rand($name)])
->setNbDoors(rand(2,6))
->setNbSeats(rand(2,70))
->setCosts(rand(3000,100000))
->setCarCategory($carCategory)
->setDisponible($dis[array_rand($dis)]);
$manager->persist($carCategory);
    $manager->persist($car);

   
}
$manager->flush();
       

      
    }
}
