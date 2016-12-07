<?php

namespace DA\MainBundle\Controller;

use DA\MainBundle\Entity\Order;
use DA\MainBundle\Entity\UserInfo;
use DA\MainBundle\Form\Type\ContactType;
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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        
        $session = $this->get('session');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        
        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('home');
        $tours = $em->getRepository('DAMainBundle:Tour')->getBestTours();
        $excursions = $em->getRepository('DAMainBundle:Excursion')->getPopularExcursion();
        return $this->render('DAMainBundle:Main:index.html.twig',
            array(
                'page'=>$page,
                'tours'=>$tours,
                'excursions'=>$excursions,
                'change' => $cnt,
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
        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('services');


        return $this->render('DAMainBundle:Main:service.html.twig',
            array(
                'object'=>$object,
                'page'=>$page
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



    /**
     * @Route("/{_locale}/basket.html", name="basket_page", defaults={"_locale" = "en"}, requirements={"_locale" = "en|ru|am|fr"})
     * @Template()
     */
    public function basketAction($slug,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ip = $request->getClientIp();
        $session = $this->get('session');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }
        $annonUsuer = $em->getRepository('DAMainBundle:UserInfo')->getUserByIp($ip);
        $order = $em->getRepository('DAMainBundle:UserInfo')->getOrderByUser($annonUsuer);

        $page = $em->getRepository('DAMainBundle:Page')->getPageBySlug('basket');
        $form = $this->createForm(new ContactType());
        
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $request->request->all();
            unset($data['contact']);

            $message = \Swift_Message::newInstance()
                ->setSubject('Discover Armenia')
                ->setFrom($form->get('email')->getData())
                ->setTo(array(
                    'contact@diacoverarmenia.tours',
                ))
                ->setBody(
                    $this->renderView(
                        'DAMainBundle:Mail:contact.html.twig',
                        array(
                            'name' => $form->get('name')->getData(),
                            'city' => $form->get('city')->getData(),
                            'telephone' => $form->get('telephone')->getData(),
                            'email' => $form->get('email')->getData(),
                            'message' => $form->get('message')->getData(),
                            'data' => $data
                        )
                    ),
                    'text/html'
                );

            $em->remove($annonUsuer);

            $em->flush();

            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('success-contact', 'mail_send');

            return $this->redirect($this->generateUrl('home_page'));

        }
        
        
        
        return $this->render('DAMainBundle:Main:basket.html.twig',
            array(
                'page'=>$page,
                'order'=>$order,
                'change' => $cnt,
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/count/basket", name="basket_count")
     * @Template()
     */
    public function countAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ip = $request->getClientIp();
        $session = $this->get('session');
        $cnt = $session->get('currentCurr');

        if(!$cnt){
            $currency = $this->connect();
            $cnt = $currency['USD'];
        }

        $annonUsuer = $em->getRepository('DAMainBundle:UserInfo')->getUserByIp($ip);
        $order = $em->getRepository('DAMainBundle:UserInfo')->getOrderByUser($annonUsuer);

        $t = 0;
        if($order){
            foreach ($order->getOrderList() as $val){
                $t += count($val);
            }
        }
        else{
            $t = null;
        }


        return $this->render('DAMainBundle:Main:count.html.twig',
            array(
                'count'=>$t,
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
            if($key == 0 || $key == 51 || $key == 9){
                $currency[$value->ISO] = array($value->ISO,$value->Rate);
            }
        }

        return $currency;
    }

}
