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

class AccommodationController extends Controller
{
    /**
     * @Route("/{_locale}/accommodation/{slug}.html", name="accommodation_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function indexAction($slug,$_locale)
    {
        if($slug == 'hotels'){
            return $this->redirectToRoute('hotels_page',array('_locale'=> $_locale));
        }
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $session->remove('cityA');
        $session->remove('starA');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        $accommodation = $em->getRepository('DAMainBundle:Accommodation')->getAccommodationByCategory($slug);

        $city = $em->getRepository('DAMainBundle:Accommodation')->getAccommodationCity($slug);


        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug($slug);

        if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }


            return $this->render('DAMainBundle:Accommodation:index.html.twig',
            array(
                'objects'=>$accommodation,
                'page' => $page,
                'city' => $city,
                'change' => $cnt,
            )
        );
    }
    /**
     * @Route("/{_locale}/accommodation/{category}/{slug}.html", name="accommodation_single", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function singleAction($slug,$category,$_locale)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        $accommodation = $em->getRepository('DAMainBundle:Accommodation')->getAccommodationBySlug($slug);
        $bestPrice = $em->getRepository('DAMainBundle:Accommodation')->getBestPriceAccommodationByCategory($accommodation->getCategory());
        $accommodationInCity = $em->getRepository('DAMainBundle:Accommodation')
            ->getAccommodationInCity($accommodation->getLocation()->getId());

        /*if(count($accommodationInCity) != 3){
            $accommodationInCity == null;
        }*/
        
        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug($category);
        $comforts = $em->getRepository('DAMainBundle:Page')->getComfortByObject('accommodation');

        if(!$accommodation && ($category !='apartament' && $category != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }


        return $this->render('DAMainBundle:Accommodation:single.html.twig',
            array(
                'object'=>$accommodation,
                'page' => $page,
                'comforts'=>$comforts,
                'accommodationInCity' =>$accommodationInCity,
                'bestPrice'=>$bestPrice,
                'change' => $cnt,
            )
        );
    }


    /**
     * @Route("/{_locale}/accommodation/{slug}/{c}/{star}", name="accommodation_filter", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     * @param $slug
     * @param $_locale
     * @param null $c
     * @param null $star
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function filterAction($slug,$_locale,$c = null,$star = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        $session = $this->get('session');

        if($session->get('cityA') != $c){

            $session->set('cityA',$c);
        }
        if($session->get('starA') != $star){
            $session->set('starA',$star);
        }
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        $accommodation = $em->getRepository('DAMainBundle:Accommodation')->filterA($slug,$c,$star);

        $city = $em->getRepository('DAMainBundle:Accommodation')->getAccommodationCity($slug);


        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug($slug);

        if(!$accommodation && ($slug !='apartment' && $slug != 'villa')){
            //throw $this->createNotFoundException('The product does not exist');
            $twig = $this->container->get('templating');

            $content = $twig->render('DAMainBundle:Exception:error404.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }


        return $this->render('DAMainBundle:Accommodation:index.html.twig',
            array(
                'objects'=>$accommodation,
                'page' => $page,
                'city' => $city,
                'star'=> !$session->get('starA') ? $star: $session->get('starA'),
                'c'=>$session->get('cityA') ?$session->get('cityA') : $c,
                'change' => $cnt,
            )
        );
    }



    public function connect(){
        $date = new \DateTime;

        try {
            $d = $date->format('d-m-Y');

            $soap = new Soap();


            $b = $soap->ExchangeRatesLatest( $d);

            $result = $b->ExchangeRatesLatestResult->Rates->ExchangeRate;

            $currency = array();

            foreach ($result as $key=>$value){
                if($key == 0 || $key == 51 || $key == 9){
                    $currency[$value->ISO] = array($value->ISO,$value->Rate);
                }
            }

            return $currency;
        } catch (Exception $e) {
            return array();
        }

    }
}
