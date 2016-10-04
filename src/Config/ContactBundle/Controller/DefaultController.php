<?php

namespace Config\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ConfigContactBundle:Default:index.html.twig');
    }
}
