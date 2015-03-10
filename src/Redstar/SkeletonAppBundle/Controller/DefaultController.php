<?php

namespace Redstar\SkeletonAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RedstarSkeletonAppBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function editAction(){
        return new Response('edit page');
    }
    
    public function homeAction(){
        return $this->render('RedstarSkeletonAppBundle:Default:home.html.twig');
    }
}
