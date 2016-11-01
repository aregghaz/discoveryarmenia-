<?php

namespace DA\MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class RoomAdmin extends AbstractAdmin
{

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC', // sort direction
        '_sort_by' => 'id' // field name
    );

    /**
     * Row form edit configuration
     *
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get all languages
        $languages = $this->configurationPool->getContainer()->getParameter('languages');
        $priceList = array();

        for ($i = 1; $i <= 12; $i++) {
            for ($k = 1; $k <= 2; $k++) {
                $array = array('m'.$i.'-'.$k.'', 'integer', array(
                    'attr' => array(
                        'class' => 'price_item'
                    )
                ));
                 array_push($priceList,$array);
            }
        }
        $formMapper->tab('Room', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->with(' ', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('type', 'choice', array(
                'label'=> 'Location Category',
                'choices' => array(
                    'standard-double-update' => 'Standard Double Update',
                    'standard-double' => 'Standard Double',
                    'standard-double/twin' => 'Standard Double/Twin',
                    'standard/twin' => 'Standard/Twin',
                    'standard-triple' => 'Standard Triple',
                    'standard-classic-sgl/dbl' => 'Standard Classic Sgl/Dbl',
                    'standard-deluxe-sgl/dbl' => 'Standard Deluxe Sgl/Dbl',
                    'standard-king-or-queen' => 'Standard King or Queen',

                    'standard-grand-king' => 'Standard Grand King',
                    'standard-grand-twin' => 'Standard Grand Twin',
                    'vip' => 'Vip',
                    'luxe-1-category' => 'Luxe 1 category',
                    'luxe-2-category' => 'Luxe 2 category',
                    'junior' => 'Junior',
                    'junior-suite-single' => 'Junior Suite Single',
                    'junior-suite-double' => 'Junior Suite double',
                    'junior-suite-twin' => 'Junior Suite Twin',
                    'junior-suite-triple' => 'Junior Suite Triple',
                    'junior-presidential' => 'Junior Presidential',
                    'family-duplex' => 'Family duplex',
                    'family-suite' => 'Family suite',

                    'family-deluxe' => 'Family Deluxe',
                    'family-quad' => 'Family Quad',
                    'superior-single' => 'Superior single',
                    'superior-double' => 'Superior double',
                    'royal-suite' => 'Royal Suite',
                    'royal-suite-single' => 'Royal Suite Single',
                    'royal-suite-double' => 'Royal Suite Double',
                    'senior-suit-sgl/dbl' => 'Senior Suit Sgl/Dbl',
                    'senior-presidential' => 'Senior Presidential',
                    'presidential-suite' => 'Presidential Suite',
                    'suite-single' => 'Suite Single',
                    'suite-double' => 'Suite Double',
                    'double' => 'Double',
                    'double-deluxe' => 'Double deluxe',
                    'double-king/twin' => 'Double King/Twin',
                    'double-superior' => 'Double Superior',
                    'tween' => 'Tween',
                    'luxe' => 'Luxe',
                    'luxe-triple' => 'Luxe triple',
                    'presedential-luxe' => 'Presedential luxe',
                    'Villa Deluxe' => 'Villa Deluxe',
                    'semi-luxe-single' => 'SEMI LUXE SINGLE',
                    'semi-luxe-double' => 'SEMI LUXE DOUBLE',
                    'studio' => 'Studio',
                    'corner-studio' => 'Corner Studio',

                    'apartment' => 'Apartment',
                    'apartment-suite-sgl/dbl' => 'Apartment Suite Sgl/Dbl',
                    'cottage' => 'Cottage',
                    'villa-king' => 'Villa King',
                    'extra-person' => 'Extra person',
                    'standard-single' => 'Tower Twin Sgl/Dbl',
                    'qottege-quad' => 'Qottege quad',
                    'econom' => 'Econom',
                    'business' => 'Business',
                    'add-person' => 'Add. person',
                    'business-single/double' => 'Business Single/Double',
                    'king/tween' => 'KING/TWIN',
                    'king/suite' => 'KING SUITE',
                    'yerevan-suite' => 'Yerevan Suite',
                    'single-queen' => 'Single Queen',
                    'comfort-dbl/twin' => 'Comfort Dbl/Twin',
                    'conference-hall' => 'Conference Hall',
                    'executive-suite' => 'Executive Suite',
                    'executive-suite-double' => 'Executive Suite Double',
                    'executive-suite-single' => 'Executive Suite Single',
                    'executive-king/twin' => 'Executive King/Twin',
                    'deluxe' => 'Deluxe',
                    'deluxe-grand-king' => 'Deluxe Grand King',
                    'deluxe-grand-twin' => 'Deluxe Grand Twin',
                    'deluxe-single' => 'Deluxe Single',
                    'deluxe-double' => 'Deluxe double',
                    'deluxe-twin' => 'Deluxe Twin',
                    'deluxe-king' => 'Deluxe KING',
                    'deluxe-king-single' => 'Deluxe King Single',
                    'deluxe-king-double' => 'Deluxe King Double',
                    'deluxe-quad-tpl' => 'Deluxe Quad Tpl',
                    'deluxe-quad-qud' => 'Deluxe Quad Qud',

                    'duplex' => 'Duplex',
                    'classic/single' => 'Classic/ single',
                    'classic/double' => 'Classic/double',
                    'presidental-single' => 'Presidental Single',
                    'presidental-double' => 'Presidental Double',

                ),
                'required' => true,
                'expanded' => false,
            ))
            ->add('visitors_number')
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Room',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                    ),
                    'description'=>array(
                        'field_type'=>'textarea',
                    ),
                    'conditions'=>array(
                        'field_type'=>'textarea',
                    )
                )
            ))
            ->add('price','sonata_type_immutable_array', array(
                'label' => 'Price List',
                'attr' => array(
                    'class' => 'price_item_block clear'
                ),
                'keys' => $priceList
            ))
            ->end()
            ->end()
            ->tab('Comforts ', array(
            'class'       => 'col-md-12',
            'box_class'   => 'box box-solid box-discover',
            // ...
            ))
            ->with('  ', array(
                'class'       => 'col-md-12 ',
                'box_class'   => 'box box-solid box-discover room_admin_block',
            ))
            ->add('comfort', 'entity',
                array(
                    'class' => 'DAMainBundle:Comfort',
                    'property' => 'name',
                    'required' => false,
                    'attr'=> array(
                        'class'=> 'list_comfort'
                    ),
                    'multiple' => true,
                    'expanded' => true,
                    'group_by' => function($val, $key, $index) {
                        switch ($val->getCategory()){
                            case 1 :
                                return 'Bathroom (Ванная комната) (Լոգարան)';
                                break;
                            case 2 :
                                return 'Bedroom (Спальня) (Ննջարան)';
                                break;
                        }
                    }
                )
            )
        ->end()
        ->end();

    }


}