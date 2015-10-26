<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Redstar\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Redstar\UserBundle\Entity\User;

/**
 * Description of userManager
 *
 * @author Ferdinand Geerman
 */
class UserManager 
{
    const ENTITY_CLASS = "Redstar\UserBundle\Entity\User.php";
    private $em;
    private $repo;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repo = $this->em->getRepository(self::ENTITY_CLASS);
    }
    
    public function getUserByUsername($username)
    {
        $user = $this->repo->findBy("username",$username);
        return $user;
    }
}
