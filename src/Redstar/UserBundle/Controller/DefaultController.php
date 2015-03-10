<?php

namespace Redstar\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RedstarUserBundle:Default:index.html.twig');
    }
}
