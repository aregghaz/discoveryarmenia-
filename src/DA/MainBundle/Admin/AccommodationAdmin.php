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

class AccommodationAdmin extends AbstractAdmin
{

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC', // sort direction
        '_sort_by' => 'id' // field name
    );

    /**
     * List show configuration
     *
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Name'))
            ->add('category', 'choice', array(
                'label'=> 'Category',
                'choices' => array(
                    'villa' => 'Villa',
                    'apartment' => 'Apartment'
                ),
            ))
            ->add('price_for_day', null, array('label' => 'Price for day'))
            ->add('price_for_month', null, array('label' => 'Price for month'))
            ->add('rooms', null, array('label' => 'Rooms'))
            ->add('_action', 'actions', array('actions' => array(
                'edit' => array(),
                'delete' => array()
            )));
    }

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

            $formMapper
            ->tab('Accommodation', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->with(' ', array(
                'class'       => 'col-md-8',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('name')
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Accommodation',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                        'required' => false,
                    ),
                    'description'=>array(
                        'field_type'=>'textarea',
                        'required' => false,
                    )
                )
            ))
            ->end()
            ->with('Info', array(
                'class'       => 'col-md-4',
                'box_class'   => 'box box-solid box-discover uploadinput',
                // ...
            ))
            ->add('image', 'sonata_type_model_list', array('required' => false))
            ->add('gallery', 'sonata_type_model_list', array('required' => false))
            ->add('price_for_day',null,array('required' => true))
            ->add('price_for_month',null,array('required' => true))
            ->add('rooms')
            ->add('location', 'entity', array(
                'class' => 'DAMainBundle:Location',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->Where('l.category = ?1')
                        ->setParameter('1','city')
                        ;
                },
                'choice_label' => 'name'
            ))
            ->add('current_location', 'entity', array(
                'class' => 'DAMainBundle:Location',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->Where('l.category = ?1')
                        ->setParameter('1','apartment')
                        ->orwhere('l.category = ?2')
                        ->setParameter('2','villa');
                },
                'choice_label' => 'name'
            ))
            ->add('category', 'choice', array(
                'label'=> 'Category',
                'choices' => array(
                    'villa' => 'Villa',
                    'apartment' => 'Apartment'
                ),
                'required' => true,
                'expanded' => false,
            ))
            ->add('best_price')
            ->end()
            ->end()
        ->tab('Comfort', array(
        'class'       => 'col-md-12',
        'box_class'   => 'box box-solid box-discover',
        // ...
    ))
        ->with('Comforts', array(
            'class'       => 'col-md-12 ',
            'box_class'   => 'box box-solid box-discover room_admin_block',
        ))

        //->add('comfort', 'sonata_type_model', array('multiple' => true, 'by_reference' => false))
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
                },
            )
        )
        ->end()
        ->end();


    }

    /**
     * Fields in list rows search
     *
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

}