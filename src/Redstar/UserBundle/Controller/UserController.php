<?php

namespace Redstar\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /*
     * 
     * List all users from the database 
     */
    public function indexAction()
    {
        
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
}
