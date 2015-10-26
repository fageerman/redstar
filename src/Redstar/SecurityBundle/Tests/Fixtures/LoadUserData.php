<?php

namespace Redstar\SecurityBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Redstar\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load the admin in the database with command: $ php app/console doctrine:fixtures:load
     */
    public function load(ObjectManager $manager)
    {
      $user = new User();
      $user->setUsername("admin");
      $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
      $user->setPassword($encoder->encodePassword('admin', $user->getSalt()));
      $user->setEmail("f.a.geerman@gmail.com");
      $manager->persist($user); 
      $this->setReference('admin', $user);
      
      $user2 = new User();
      $user2->setUsername("user");
      $user2->setPassword($encoder->encodePassword('user', $user2->getSalt()));
      $user2->setEmail("user@gmail.com");
      $user2->setLocked(true);
      $manager->persist($user2); 
      $this->setReference('user', $user2);
      
      $user3 = new User();
      $user3->setUsername("testuser");
      $user3->setPassword($encoder->encodePassword('test', $user3->getSalt()));
      $user3->setEmail("testuser@gmail.com");
      $user3->setExpiresAt(new \DateTime('2015-10-14 00:00:00'));
      $manager->persist($user3); 
      $manager->flush();
    }
}
