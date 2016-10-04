<?php

namespace Config\MediaBundle\Controller;

use Config\MediaBundle\Entity\Media;
use Config\MediaBundle\Model\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $test = new Media();
        var_dump(dump($test->test()));
        //var_dump(dump($this->container));
        exit;
        return $this->render('ConfigMediaBundle:Default:index.html.twig');
    }
}
