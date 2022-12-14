<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public  function  __construct(UserPasswordHasherInterface $encoders)

    {

        $this->encoder = $encoders;
    }

    public function load(ObjectManager $manager)
    {
        
        $user= new User();
        
        $user->setUsername('silatcha')
        ->setPassword(" ");
      
        $manager->persist($user);
        $manager->flush();
    }
}
