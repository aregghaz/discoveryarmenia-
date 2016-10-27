<?php

namespace DA\MainBundle\Controller;

use DA\MainBundle\Entity\TourName;
use Gedmo\Mapping\Driver\Chain;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TourController extends Controller
{
    /**
     * @Route("/{_locale}/tours.html", name="tours_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function indexAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $excursions = $em->getRepository('DAMainBundle:Tour')->getAllTours();

        $city = $em->getRepository('DAMainBundle:Tour')->getToursCity();

        $tourType = $em->getRepository('DAMainBundle:Tour')->getCategory();

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('tours');

        /*if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }*/


        return $this->render('DAMainBundle:Tours:index.html.twig',
            array(
                'objects'=>$excursions,
                'page' => $page,
                'city' => $city,
                'tourType' => $tourType
            )
        );
    }

    /**
     * @Route("/{_locale}/tour/{id}/{slug}.html", name="tour_single", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function singleAction($slug,$id,$_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $tour = $em->getRepository('DAMainBundle:Tour')->getTourBySlug($id);
        $tourInCategory = $em->getRepository('DAMainBundle:Tour')
            ->getTourInCategory($tour->getTourName()->getCategory()->getId());

        /*if(count($accommodationInCity) != 3){
            $accommodationInCity == null;
        }*/

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('tours');

        if(!$tour ){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }


        return $this->render('DAMainBundle:Tours:single.html.twig',
            array(
                'object'=>$tour,
                'page' => $page,
                'tourInCategory' =>$tourInCategory,
            )
        );
    }

}
