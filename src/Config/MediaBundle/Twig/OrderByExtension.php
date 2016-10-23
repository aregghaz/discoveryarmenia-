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
            'orderList' => new Twig_Filter_Method($this, 'orderList'),
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
    public function orderList($array) {

        var_dump(dump($array));exit;

        $newArray = array();
        foreach($array as $new){
            if($new->getCategory())
                $newArray[$new->getId()]  = $new;
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