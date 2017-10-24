<?php

namespace Config\MediaBundle\Controller\Rest;

use Config\MediaBundle\Entity\Media;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
 * @Rest\RouteResource("Media")
 * @Rest\Prefix("/api")
 */
class MediaRestController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Media",
     *  description="This function is used to get a Ad by search keyword.",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Not Allowed",
     *         404="Returned when the BaseCompany is not found"
     *     }
     * )
     * @Rest\View()
     * @Post("/get/media/{start}")
     * @param $start
     * @return JsonResponse
     */
    public function UploadAction($start)
    {
        $em = $this->getDoctrine()->getManager();
        $media = $em->getRepository('ConfigMediaBundle:Media')->selectMedia($start);
        $paths = array();
        $count = $media['count'];
        foreach($media['result'] as $img){
            $paths[$img->getId()] = [$img->getWebPath(),$img->getRealName()];
        }
        return new JsonResponse(array($paths,$count));
    }
}