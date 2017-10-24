<?php
namespace DA\MainBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class CurrencyExtension extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction("localizedcurrency", array($this, "localizedcurrency")),
        );
    }
    public function localizedcurrency($currency = 'USD') {
        switch ($currency){
            case 'USD':
                return '$';
            break;
            case 'RUB':
                return '₽';
            break;
            case 'EUR':
                return '€';
            break;
            default:
                return "";
        }
    }


    public function getName()
    {
        return 'currency_extension';
    }
}