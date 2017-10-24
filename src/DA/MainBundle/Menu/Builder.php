<?php
namespace DA\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function generalMenu(FactoryInterface $factory, array $options){
        
        $em = $this->container->get('doctrine')->getManager();

        $menu = $factory->createItem('root');

        /* ------- accommodation ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('accommodation');

        $menu->addChild('accommodation', array(
            'route' => false,
            'routeParameters' => array('slug' =>$da->getSlug()),
            'attributes'=>array('class'=>'dropdown')))
            ->setLabel($da->getTitle());
        $menu['accommodation']->setChildrenAttribute('class', 'sub-menu clear');
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('hotels');
        $menu['accommodation']->addChild('hotels',
            array(
                'route' => 'hotels_page'
            )
        )->setLabel($da->getTitle());
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('apartment');
        $menu['accommodation']->addChild('apartment',
            array(
                'route' => 'accommodation_page',
                'routeParameters' => array('slug' =>$da->getSlug())
            )
        )->setLabel($da->getTitle());
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('villa');
        $menu['accommodation']->addChild('villa',
            array(
                'route' => 'accommodation_page',
                'routeParameters' => array('slug' =>$da->getSlug())
            )
        )->setLabel($da->getTitle());
        /* ------- accommodation ------- */

        /* ------- transport ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('transport');

        $menu->addChild('transport', array(
            'route' => false,
            'routeParameters' => array('slug' =>$da->getSlug()),
            'attributes'=>array('class'=>'dropdown')))
            ->setLabel($da->getTitle());
        $menu['transport']->setChildrenAttribute('class', 'sub-menu clear');
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('car-with-driver');
        $menu['transport']->addChild('car-with-driver',
            array(
                'route' => 'transport_page',
                'routeParameters' => array('slug' =>$da->getSlug())
            )
        )->setLabel($da->getTitle());
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('car-rent');
        $menu['transport']->addChild('car-rent',
            array(
                'route' => 'transport_page',
                'routeParameters' => array('slug' =>$da->getSlug())
            )
        )->setLabel($da->getTitle());
        /* ------- transport ------- */

        /* ------- excursion ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('excursion');

        $menu->addChild('excursion', array(
            'route' => 'excursion_page',
        ))
            ->setLabel($da->getTitle());

        /* ------- excursion ------- */

        /* ------- tours ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('tours');

        $menu->addChild('tours', array(
            'route' => 'tours_page'
        ))
            ->setLabel($da->getTitle());

        /* ------- tours ------- */

        /* ------- services ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('services');

        $menu->addChild('services', array(
            'route' => false,
            'attributes'=>array('class'=>'dropdown')))
            ->setLabel($da->getTitle());
        $services = $em->getRepository('DAMainBundle:Service')->findAll();
        $menu['services']->setChildrenAttribute('class', 'sub-menu clear');
        foreach ($services as $item){
            $menu['services']->addChild($item->getSlug(),
                array(
                    'route' => 'service_page',
                    'routeParameters' => array('slug' =>$item->getSlug())
                )
            )->setLabel($item->getTitle());
        }


        /* ------- services ------- */

        /* ------- armenia ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('armenia');

        $menu->addChild('armenia', array(
            'route' => null, 'attributes'=>array('class'=>'dropdown')
        ))
            ->setLabel($da->getTitle());
        $armenia = $em->getRepository('DAMainBundle:Armenia')->findAll();
        $menu['armenia']->setChildrenAttribute('class', 'sub-menu clear');
        foreach ($armenia as $item){
            $menu['armenia']->addChild($item->getSlug(),
                array(
                    'route' => 'armenia_page',
                    'routeParameters' => array('slug' =>$item->getSlug())
                )
            )->setLabel($item->getTitle());
        }
        /* ------- armenia ------- */

        /* ------- company ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('company');

        $menu->addChild('company', array(
            'route' => 'company_page',
        ))
            ->setLabel($da->getTitle());

        /* ------- company ------- */

        /* ------- contact ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('contact');

        $menu->addChild('contact', array(
            'route' => 'contact_page',
        ))
            ->setLabel($da->getTitle());

        /* ------- contact ------- */

        return $menu;
    }

    public function footerMenu(FactoryInterface $factory, array $options){

        $em = $this->container->get('doctrine')->getManager();

        $menu = $factory->createItem('footer');

        /* ------- accommodation ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('hotels');
        $menu->addChild('hotels', array(
            'route' => 'hotels_page'))
            ->setLabel($da->getTitle());
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('apartment');
        $menu->addChild('apartment', array(
            'route' => 'hotels_page',
            'routeParameters' => array('slug' =>$da->getSlug())))
            ->setLabel($da->getTitle());
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('villa');
        $menu->addChild('apartment', array(
            'route' => 'hotels_page',
            'routeParameters' => array('slug' =>$da->getSlug())))
            ->setLabel($da->getTitle());
        /* ------- accommodation ------- */

        /* ------- transport ------- */
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('car-with-driver');
        $menu->addChild('car-with-driver', array(
            'route' => 'transport_page',
            'routeParameters' => array('slug' =>$da->getSlug())))
            ->setLabel($da->getTitle());
        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('car-rent');
        $menu->addChild('car-rent', array(
            'route' => 'transport_page',
            'routeParameters' => array('slug' =>$da->getSlug())))
            ->setLabel($da->getTitle());
        /* ------- transport ------- */

        /* ------- excursion ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('excursion');

        $menu->addChild('excursion', array(
            'route' => 'excursion_page',
        ))
            ->setLabel($da->getTitle());

        /* ------- excursion ------- */

        /* ------- tours ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('tours');

        $menu->addChild('tours', array(
            'route' => 'tours_page'
        ))
            ->setLabel($da->getTitle());

        /* ------- tours ------- */

        /* ------- company ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('company');

        $menu->addChild('company', array(
            'route' => 'company_page',
        ))
            ->setLabel($da->getTitle());

        /* ------- company ------- */

        /* ------- contact ------- */

        $da =  $em->getRepository('DAMainBundle:Page')->getPageBySlug('contact');

        $menu->addChild('contact', array(
            'route' => 'contact_page',
        ))
            ->setLabel($da->getTitle());

        /* ------- contact ------- */

        return $menu;
    }
}