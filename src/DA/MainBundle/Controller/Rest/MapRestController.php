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
 * @Rest\RouteResource("Map")
 * @Rest\Prefix("/api")
 */
class MapRestController extends FOSRestController
{
    const ENTITY = 'DAMainBundle:Location';

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Map",
     *  description="This function is used to get a Ad by search keyword.",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Not Allowed",
     *         404="Returned when the BaseCompany is not found"
     *     }
     * )
     * @Rest\View(serializerGroups={"location"})
     * @Get("/location/{id}")
     * @param $id
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('a')
            ->from(self::ENTITY, 'a')
            ->where('a.id = :id' );
        $query->setParameter('id', $id);

        return $query->getQuery()->getResult();
    }
}