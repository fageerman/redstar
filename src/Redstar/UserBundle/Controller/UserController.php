<?php

namespace Redstar\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Redstar\UserBundle\Entity\User;


class UserController extends Controller 
{
   
    
    public function listAction()
    {
        $userManager = $this->get('redstar_user_manager');
        $allUser = $userManager->getAllUsers();
        
        return $this->render('RedstarUserBundle:Default:list.html.twig', array(
            'users'=>$allUser
        ));
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
