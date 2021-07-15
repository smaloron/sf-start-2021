<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param $passwordEncoder
     */
    public function __construct( UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUserName("toto")
             ->setRoles(["ROLE_USER"])
             ->setPassword(
                 $this->passwordEncoder->hashPassword(
                     $user,
                     "123"
                 )
             );

        $manager->persist($user);

        $user = new User();
        $user->setUserName("admin")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword(
                $this->passwordEncoder->hashPassword(
                    $user,
                    "123"
                )
            );

        $manager->persist($user);

        $manager->flush();
    }
}
