<?php

namespace Redstar\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Redstar\UserBundle\Entity\User;
use Redstar\UserBundle\Entity\Role;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
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
        var_dump('getting container here');
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
      $user->setPassword($encoder->encodePassword('Aruba!23', $user->getSalt()));
      $user->setEmail("f.a.geerman@gmail.com");
      $manager->persist($user); 
      $manager->flush();
      
    }
}
