<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Redstar\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Redstar\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Description of userManager
 *
 * @author Ferdinand Geerman
 */
class UserManager extends ContainerAware
{
    const ENTITY_CLASS = "Redstar\UserBundle\Entity\User";
    private $encoderFactory;
    private $em;
    private $repo;
    
    public function __construct(EncoderFactoryInterface $encoderFactory, EntityManager $em) {
        $this->encoderFactory = $encoderFactory;
        $this->em = $em;
        $this->repo = $this->em->getRepository(self::ENTITY_CLASS);
    }
    
    public function getUserByUsername($username)
    {
        $user = $this->repo->findOneBy(array('username'=>$username));
        return $user;
    }
    
    public function setUserPassword(UserInterface $user, $plainpassword)
    {
        $hash = $this->encoderFactory
                ->getEncoder($user)->encodePassword($plainpassword, null);
        $user->setPassword($hash);
    }
    
    public function getAllUsers()
    {
        $allUser = $this->repo->findAll();
        return $allUser;
    }
    
    public function findUserBy(array $criteria)
    {
        if(empty($criteria)){
            return new MissingOptionsException('Empty array given as options');
        }
        
        $user =  $this->repo->findOneBy($criteria);
        return $user;
    }
    
    public function flushUser(User $user)
    {
        $this->em->flush($user);
    }
}
