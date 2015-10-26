<?php

namespace Redstar\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Redstar\UserBundle\Entity\User;

class ForgotPasswordController extends Controller
{
       
    public function forgotPasswordAction(User $id)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    public function checkMailAction()
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    public function resetPasswordAction($token)
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    public function resetPasswordExpiredAction()
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
    
    
    
   
}
