<?php
namespace Config\MediaBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class OrderByExtension extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            'order' => new Twig_Filter_Method($this, 'order'),
            'sortPosition' => new Twig_Filter_Method($this, 'sortPosition'),
        );
    }
    public function order($array,$dir = 'asc') {
        $newArray = array();
        foreach($array as $new){
            if($new->getPosition())
                $newArray[$new->getPosition()]  = $new;
            else
                $newArray[]  = $new;
        }
        ksort($newArray);
        return $newArray ;
    }
    public function sortPosition($array,$dir = 'asc') {
        $newArray = array();
        foreach($array as $new){
            if($new->getPosition())
                $newArray[$new->getPosition()]  = $new;
            else
                $newArray[]  = $new;
        }
        ksort($newArray);
        return $newArray ;
    }

    public function getName()
    {
        return 'order_extension';
    }
}