<?php
namespace Config\MediaBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class MediaExtension extends Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction("media", array($this, "media")),
        );
    }
    public function media($media,$type = null) {
        if(!$media){
            return;
        }
        if($type){
            if($media->getWidth() > 150){
                return $media->getAbsoluteCropWebPath($type,$media->getName());
            }
            else{
                return $media->getWebPath();
            }
        }
        
        return $media->getWebPath();
    }

    public function getName()
    {
        return 'media_extension';
    }
}