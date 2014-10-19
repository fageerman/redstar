<?php

namespace Redstar\SkeletonAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RedstarSkeletonAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
