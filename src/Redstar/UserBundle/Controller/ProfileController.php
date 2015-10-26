<?php

namespace Redstar\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Redstar\UserBundle\Entity\User;

class ProfileController extends Controller
{
       
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
