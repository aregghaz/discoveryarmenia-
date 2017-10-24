<?php
namespace Config\MediaBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class YoutubeExtension extends Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction("youtube", array($this, "youtube"),
            array('is_safe' => array('html'))
            ),
        );
    }
    public function youtube($object) {

        $width = $object->getWidth()?$object->getWidth(): 640;
        $height = $object->getHeight()?$object->getWidth(): 360;

        $output = '<iframe 
                    id="y_video" 
                    frameborder="0" 
                    allowfullscreen="1" 
                    title="'.$object->getName().'" 
                    width="'.$width.'" 
                    height="'.$height.'" 
                    src="https://www.youtube.com/embed/'.$object->getVideoId().'?autoplay='.$object->getAutoplay().'&controls='.$object->getControls().'&start='.$object->getStart().'&end='.$object->getEnd().'&showinfo='.$object->getShowinfo().'&modestbranding='.$object->getModestbranding().'&loop='.$object->getLoopVideo().'&fs='.$object->getFs().'&iv_load_policy='.$object->getIvLoadPolicy().'&autohide='.$object->getAutohide().'&enablejsapi=1&origin=;widgetid=1"></iframe>';

       return $output;
    }

    public function getName()
    {
        return 'youtube_extension';
    }
}