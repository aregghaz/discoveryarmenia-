<?php

namespace Config\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ConfigAdminBundle:Default:index.html.twig');
    }
}
