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
use SoapClient;

class TourController extends Controller
{
    /**
     * @Route("/{_locale}/tours.html", name="tours_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function indexAction($_locale)
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->get('session');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        
        $tours = $em->getRepository('DAMainBundle:Tour')->getAllTours();

        $city = $em->getRepository('DAMainBundle:Tour')->getToursCity();

        $tourType = $em->getRepository('DAMainBundle:Tour')->getAllToursCategory();
        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('tours');

        /*if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }*/


        return $this->render('DAMainBundle:Tours:index.html.twig',
            array(
                'objects'=>$tours,
                'page' => $page,
                'city' => $city,
                'tourType' => $tourType,
                'change' => $cnt,
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

        $session = $this->get('session');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        
        $tour = $em->getRepository('DAMainBundle:Tour')->getTourBySlug($id);
        $excursions = $em->getRepository('DAMainBundle:Excursion')->findAll();
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
                'change' => $cnt,
                'excursion'=>$excursions,
            )
        );
    }

    public function connect(){
        $date = new \DateTime;


        $d = $date->format('d-m-Y');
        $soap = new Soap();


        $b = $soap->ExchangeRatesLatest( $d);

        $result = $b->ExchangeRatesLatestResult->Rates->ExchangeRate;

        $currency = array();
        foreach ($result as $key=>$value){
            if($key == 0 || $key == 50 || $key == 9){
                $currency[$value->ISO] = array($value->ISO,$value->Rate);
            }
        }

        return $currency;
    }
}
