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
use SoapClient;

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
        $tours = $em->getRepository('DAMainBundle:Tour')->getBestTours();
        $excursions = $em->getRepository('DAMainBundle:Excursion')->getPopularExcursion();
        return $this->render('DAMainBundle:Main:index.html.twig',
            array(
                'page'=>$page,
                'tours'=>$tours,
                'excursions'=>$excursions
            )
        );
    }

    /**
     * @Route("/{_locale}/service/{slug}.html", name="service_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function serviceAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $object = $em->getRepository('DAMainBundle:Service')->getServiceBySlug($slug);

        return $this->render('DAMainBundle:Main:service.html.twig',
            array(
                'object'=>$object
            )
        );
    }

    /**
     * @Route("/{_locale}/company.html", name="company_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function companyAction()
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('company');

        return $this->render('DAMainBundle:Main:company.html.twig',
            array(
                'page'=>$page
            )
        );
    }

    /**
     * @Route("/{_locale}/armenia/{slug}.html", name="armenia_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function armeniaAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('armenia');
        
        $armenia = $em->getRepository('DAMainBundle:Armenia')->getArmeniaBySlug($slug);

        return $this->render('DAMainBundle:Main:armenia.html.twig',
            array(
                'object'=> $armenia,
                'page'=>$page
            )
        );
    }

    /**
     * @Route("/{_locale}/contact.html", name="contact_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function contactAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('contact');
        

        return $this->render('DAMainBundle:Main:contact.html.twig',
            array(
                'page'=>$page
            )
        );
    }

    /**
     * @Route("/{_locale}/currency", name="currency",defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|it"})
     * @Template()
     */
    public function CurrencyAction()
    {
        $currency = $this->connect();
        $session = $this->get('session');
        $currentCurrency = $currency['USD'];

        if($session->get('currentCurr') == null || empty($session->get('currentCurr'))){
            $session->set('currentCurr',$currency['USD']);
        }else{
            $currentCurrency = $session->get('currentCurr');
        }


        $session->set('allCurr',$currency);
        return $this->render('DAMainBundle:Blocks:currency.html.twig',
            array(
                'exchange'=>$currency,
                'currentCurrency' =>  $currentCurrency
            )
        );
    }


    /**
     * @Route("/soap/{iso}", name="currency",defaults={"iso" = "USD"}, requirements={"iso" = "USD|RUB|EUR"})
     * @Template()
     */
    public function SoapAction(Request $request, $iso)
    {
        $session = $this->get('session');
        $all = $session->get('allCurr');
        $session->set('currentCurr',$all[$iso]);

        return $this->redirect($this->container->get('request')->headers->get('referer'));
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
