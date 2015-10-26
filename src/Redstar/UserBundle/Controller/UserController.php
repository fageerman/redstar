<?php

namespace Redstar\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Redstar\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserController extends Controller
{
    /*
     * List all users from the database 
     */
    
    private $em;
    
    public function __construct() {
        $this->em = $this->getDoctrine()->getManager();
    }
    public function listAction()
    {
        
        return $this->render('RedstarUserBundle:Default:list.html.twig');
    }
    
    public function newAction()
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    public function showAction(User $id)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
            
    public function editAction(User $id)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }  
    
    public function deleteAction(User $id)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    public function viewProfileAction(User $id)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    public function editProfileAction(User $id)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    public function profileChangePasswordAction(User $id)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
}
