<?php

namespace App\DataFixtures;

use App\Entity\AppUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppUserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user_admin = new AppUser();
        $user_admin->setEmail('admin@example.com');
        $user_admin->setRoles(['ROLE_ADMIN']);

        $password = $this->encoder->encodePassword($user_admin, 'admin');
        $user_admin->setPassword($password);

        $manager->persist($user_admin);

        $user = new AppUser();
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);

        $password = $this->encoder->encodePassword($user, 'user');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}
