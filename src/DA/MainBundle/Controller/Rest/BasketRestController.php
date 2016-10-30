<?php

namespace DA\MainBundle\Controller\Rest;

use Config\MediaBundle\Entity\Media;
use DA\MainBundle\Entity\Order;
use DA\MainBundle\Entity\UserInfo;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\ORM\Mapping as ORM;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;


/**
 * @Rest\RouteResource("Basket")
 * @Rest\Prefix("/api")
 */
class BasketRestController extends FOSRestController
{

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Basket",
     *  description="This function is used to get a Ad by search keyword.",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Not Allowed",
     *         404="Returned when the BaseCompany is not found"
     *     }
     * )
     * @Rest\View()
     * @Post("/add/basket")
     * @param Request $request
     * @return Response
     */
    public function basketAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $array = $request->request->all();
        $ip = $request->getClientIp();
        $user = $this->get('security.context')->getToken()->getUser();


        $annonUsuer = $em->getRepository('DAMainBundle:UserInfo')->getUserByIp($ip);
        $order = $em->getRepository('DAMainBundle:UserInfo')->getOrderByUser($annonUsuer);
        $req = array();

        if($annonUsuer == null && $user == 'anon.'){
            $annonUsuer = new UserInfo();
            $order = new Order();
            $annonUsuer->setUserIp($ip);
            $order->setUserInfo($annonUsuer);
            $em->persist($annonUsuer);
            switch ($array['type']){
                case 'room':
                    $req['hotel'] =  array($array['id']=>$array);
                    break;
                case 'accommodation':
                    $req['accommodation'] =  array($array['id']=>$array);
                    break;
                case 'transfer':
                    $req['transfer'] =  array($array['id']=>$array);
                    break;
                case 'rent_car':
                    $req['rent_car'] =  array($array['id']=>$array);
                    break;
                case 'excursion':
                    $req['excursion'] =  array($array['id']=>$array);
                    break;
            }
            $order->setOrderList($req);
        }
        else{
            $list = $order->getOrderList();
            switch ($array['type']){
                case 'room':
                    $req =  $array;
                    if(array_key_exists('hotel',$list)){
                        array_push($list['hotel'],$req);
                    }
                    else{
                        $list['hotel'] =  array($array['id']=>$array);
                    }
                    break;
                case 'accommodation':
                    $req =  $array;
                    if(array_key_exists('accommodation',$list)){
                        array_push($list['accommodation'],$req);
                    }
                    else{
                        $list['accommodation'] =  array($array['id']=>$array);
                    }
                    break;
                case 'transfer':
                    $req =  $array;
                    if(array_key_exists('transfer',$list)){
                        array_push($list['transfer'],$req);
                    }
                    else{
                        $list['transfer'] =  array($array['id']=>$array);
                    }
                    break;
                case 'rent_car':
                    $req =  $array;
                    if(array_key_exists('rent_car',$list)){
                        array_push($list['rent_car'],$req);
                    }
                    else{
                        $list['rent_car'] =  array($array['id']=>$array);
                    }
                    break;
                case 'excursion':
                    $req =  $array;
                    if(array_key_exists('excursion',$list)){
                        array_push($list['excursion'],$req);
                    }
                    else{
                        $list['excursion'] =  array($array['id']=>$array);
                    }
                    break;
            }

            $order->setOrderList($list);

        }

        $em->persist($order);

        $em->flush();
        /*if($user != 'anon.'){
            var_dump($user->getId());exit;
        }
        else{


        }*/

         return true;




    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Basket",
     *  description="This function is used to get a Ad by search keyword.",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Not Allowed",
     *         404="Returned when the BaseCompany is not found"
     *     }
     * )
     * @Rest\View()
     * @Post("/check/basket")
     * @param Request $request
     * @return Response
     */
    public function basketCheckAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ip = $request->getClientIp();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $annonUsuer = $em->getRepository('DAMainBundle:UserInfo')->getUserByIp($ip);
        $order = $em->getRepository('DAMainBundle:UserInfo')->getOrderByUser($annonUsuer);
        if($order){
            $c = $order->getOrderList();
            $d = 0;
            foreach ($c as $val){
                $d =  count($val);
            }
        }
        else{
            $d = 1;
        }

        return new Response($d);




    }

}