<?php

namespace Config\MediaBundle\Controller\Rest;

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
 * @Rest\RouteResource("Upload")
 * @Rest\Prefix("/api")
 */
class UploadRestController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Upload",
     *  description="This function is used to get a Ad by search keyword.",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Not Allowed",
     *         404="Returned when the BaseCompany is not found"
     *     }
     * )
     * @Rest\View()
     * @Post("/upload/media")
     * @param Request $request
     * @return Media
     */
    public function UploadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $file = $request->files->all();
        $media = new Media();
        $media->setFile($file['file']);
        $media->setContext('default');
        $em->persist($media);
        $em->flush();
        return $media;
    }
}