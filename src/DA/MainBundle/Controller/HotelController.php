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


class HotelController extends Controller
{
    /**
     * @Route("/{_locale}/hotels.html", name="hotels_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function indexAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $session->remove('city');
        $session->remove('star');
        $hotles = $em->getRepository('DAMainBundle:Hotel')->findAll();

        $city = $em->getRepository('DAMainBundle:Hotel')->getHotelsCity();


        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('hotels');

        /*if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }*/


        return $this->render('DAMainBundle:Hotel:index.html.twig',
            array(
                'objects'=>$hotles,
                'page' => $page,
                'city' => $city
            )
        );
    }
    /**
     * @Route("/{_locale}/hotels/{slug}.html", name="single_hotel", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function  singleAction($slug,$_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $hotel = $em->getRepository('DAMainBundle:Hotel')->getHotelBySlug($slug);
        $bestPrice = $em->getRepository('DAMainBundle:Hotel')->getBestPriceHotel();
        $hotelInCity = $em->getRepository('DAMainBundle:Hotel')
            ->getHotelInCity($hotel->getLocation()->getId());

        /*if(count($hotelInCity) != 3){
            $accommodationInCity == null;
        }*/

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('hotels');
        $comforts = $em->getRepository('DAMainBundle:Page')->getComfortByObject('hotel');

        if(!$hotel ){
            //throw $this->createNotFoun{{ dump(city) }}dException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }


        return $this->render('DAMainBundle:Hotel:single.html.twig',
            array(
                'object'=>$hotel,
                'page' => $page,
                'comforts'=>$comforts,
                'hotelInCity' =>$hotelInCity,
                'bestPrice'=>$bestPrice
            )
        );
    }


    /**
     * @Route("/{_locale}/hotels/{c}/{star}", name="filter_hotel", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     * @param null $c
     * @param $star
     * @return Response
     */
    public function filterAction($c = null,$star = null)
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->get('session');
     
        if($session->get('city') != $c){

            $session->set('city',$c);
        }
        if($session->get('star') != $star){
            $session->set('star',$star);
        }

        
        $hotles = $em->getRepository('DAMainBundle:Hotel')->filterHotel($c,$star);

        $city = $em->getRepository('DAMainBundle:Hotel')->getHotelsCity();
        $cityArray = array();


        foreach ($city as $value){
            $cityArray[$value->getId()] = $value;
        }

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('hotels');

        /*if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }*/


        return $this->render('DAMainBundle:Hotel:index.html.twig',
            array(
                'objects'=>$hotles,
                'page' => $page,
                'city' => $city,
                'star'=> !$session->get('star') ? $star: $session->get('star'),
                'c'=>$session->get('city') ?$session->get('city') : $c
            )
        );
    }
}
