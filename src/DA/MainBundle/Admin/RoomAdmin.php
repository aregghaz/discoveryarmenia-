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
                    'single' => 'Single',
                    'double' => 'Double/Twin',
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