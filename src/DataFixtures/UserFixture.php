<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{   
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(PersistenceObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i){
            $user = new User();

            $user->setEmail(sprintf("spacebar%d@example.com", $i));
            $user->setFirstName($this->faker->firstName());
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));

            return $user;
        });

        $manager->flush();
    }
}