<?php

namespace DA\MainBundle\Controller;

use Gedmo\Mapping\Driver\Chain;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class MainController extends Controller
{
    /**
     * @Route("/{_locale}", name="home_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('home');
        
        return $this->render('DAMainBundle:Main:index.html.twig',
            array(
                'page'=>$page
            )
        );
    }
    
}
