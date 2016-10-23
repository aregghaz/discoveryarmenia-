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

class ExcursionController extends Controller
{
    /**
     * @Route("/{_locale}/excursion.html", name="excursion_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function indexAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $excursions = $em->getRepository('DAMainBundle:Excursion')->findAll();

        $city = $em->getRepository('DAMainBundle:Excursion')->getExcursionCity();


        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('excursion');

        /*if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }*/


        return $this->render('DAMainBundle:Excursion:index.html.twig',
            array(
                'objects'=>$excursions,
                'page' => $page,
                'city' => $city
            )
        );
    }

    /**
     * @Route("/{_locale}/excursion/{slug}.html", name="excursion_single", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function singleAction($slug,$_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $excursion = $em->getRepository('DAMainBundle:Excursion')->getExcursionnBySlug($slug);
        $bestPrice = $em->getRepository('DAMainBundle:Excursion')->getBestExcursion();
        $excursionInCity = $em->getRepository('DAMainBundle:Excursion')
            ->getExcursionInCity($excursion->getLocation()->getId());

        /*if(count($accommodationInCity) != 3){
            $accommodationInCity == null;
        }*/

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('excursion');

        if(!$excursion){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }


        return $this->render('DAMainBundle:Excursion:single.html.twig',
            array(
                'object'=>$excursion,
                'page' => $page,
                'excursionInCity' =>$excursionInCity,
                'bestPrice'=>$bestPrice
            )
        );
    }
}
