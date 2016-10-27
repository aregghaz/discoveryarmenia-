<?php

namespace DA\MainBundle\Controller\Rest;

use Config\MediaBundle\Entity\Media;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
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
 * @Rest\RouteResource("Filter")
 * @Rest\Prefix("/api")
 */
class FilterRestController extends FOSRestController
{
    const HOTEL = 'DAMainBundle:Hotel';
    const ACCOMMODATION = 'DAMainBundle:Accommodation';
    const EXCURSION = 'DAMainBundle:Excursion';
    const TOUR = 'DAMainBundle:TourName';

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Filter",
     *  description="This function is used to get a Ad by search keyword.",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Not Allowed",
     *         404="Returned when the BaseCompany is not found"
     *     }
     * )
     * @Rest\View(serializerGroups={"filter"})
     * @Get("/hotel/{city}/{star}")
     * @param null $city
     * @param null $star
     * @return
     */
    public function hotelAction($city = null,$star = null)
    {
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('a')
            ->from(self::HOTEL, 'a');
        if($city != 'null'){
            $query->where('a.location = :city' );
            $query->setParameter('city', $city);
        }
        if($star != 'null'){
            $query->where('a.star = :star' );
            $query->setParameter('star', $star);
        }
        
        return $query->getQuery()->getResult();
    }
    
}