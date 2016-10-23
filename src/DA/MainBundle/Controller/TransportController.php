<?php

namespace DA\MainBundle\Controller;

use DA\MainBundle\Entity\CarRent;
use Gedmo\Mapping\Driver\Chain;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TransportController extends Controller
{
    /**
     * @Route("/{_locale}/transport/{slug}.html", name="transport_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function transferAction($slug,$_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug($slug);
        if($slug == 'car-rent'){
            $car_rent = $em->getRepository('DAMainBundle:CarRent')->findAll();
            $carType = CarRent::$catRentType;
            return $this->render('DAMainBundle:Transport:car_rent.html.twig',
                array(
                    'objects'=>$car_rent,
                    'page' => $page,
                    'carType'=>$carType
                )
            );
        }
        elseif($slug == 'car-with-driver'){
            $transfer = $em->getRepository('DAMainBundle:Transfer')->findAll();

            return $this->render('DAMainBundle:Transport:transfer.html.twig',
                array(
                    'objects'=>$transfer,
                    'page' => $page,
                )
            );
        }
        else{
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }
        
    }
    /**
     * @Route("/{_locale}/transport/{slug}.html", name="car_rent_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function carRentAction($slug,$_location)
    {
        $em = $this->getDoctrine()->getManager();

        $car_rent = $em->getRepository('DAMainBundle:CarRent')->findAll();

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug($slug);

        /*if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }*/


        return $this->render('DAMainBundle:Transport:car_rent.html.twig',
            array(
                'objects'=>$car_rent,
                'page' => $page,
            )
        );
    }
}
