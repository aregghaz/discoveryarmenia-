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
        $session = $this->get('session');
        $session->remove('cityE');

        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        
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
                'city' => $city,
                'change' => $cnt,
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
        $session = $this->get('session');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }

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
                'bestPrice'=>$bestPrice,
                'change' => $cnt,
            )
        );
    }


    /**
     * @Route("/{_locale}/excursion/{c}", name="excursion_filter", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function filterAction($_locale,$c)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');

        if($session->get('cityE') != $c){

            $session->set('cityE',$c);
        }
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }


        $excursions = $em->getRepository('DAMainBundle:Excursion')->filterExcursion($c);

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
                'city' => $city,
                'c'=>$session->get('cityE') ?$session->get('cityE') : $c,
                'change' => $cnt,
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
