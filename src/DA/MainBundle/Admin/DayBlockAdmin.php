<?php

namespace DA\MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
//use Travel\MainBundle\Entity\Seo;

class DayBlockAdmin extends AbstractAdmin
{

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC', // sort direction
        '_sort_by' => 'id' // field name
    );

    /**
     * Row show configuration
     *
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array('label' => 'ID'))
            ->add('name', null, array('label' => 'Title'));
    }

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
            ->tab('Day', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->with('  ', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-danger',
                // ...
            ))
            ->add('name',null)
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Armenia',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                    )
                    ,
                    'location'=>array(
                        'field_type'=>'text',
                        'attr'=>array('class'=>'tokenfield')
                    ),
                    'description'=>array(
                        'field_type'=>'textarea',
                    )
                )
            ))
            ->add('gallery', 'sonata_type_model_list', array('required' => false))
            ->end()
            ->end()
            ->tab('Hotels ', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->with(' ', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-danger',
                // ...
            ))
            ->add('hotel_3star','entity',array(
                'required'=>false,
                'label' => 'Hotel ⋆ ⋆ ⋆',
                'class' => 'DAMainBundle:Hotel',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.star = 3');
                },
                'choice_label' => 'name',
            ))
            ->add('hotel_4star','entity',array(
                'required'=>false,
                'label' => 'Hotel ⋆ ⋆ ⋆ ⋆',
                'class' => 'DAMainBundle:Hotel',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.star = 4');
                },
                'choice_label' => 'name',
            ))
            ->add('hotel_5star','entity',array(
                'required'=>false,
                'label' => 'Hotel ⋆ ⋆ ⋆ ⋆ ⋆',
                'class' => 'DAMainBundle:Hotel',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.star = 5');
                },
                'choice_label' => 'name',
                'group_by' => function($val, $key, $index) {
                    return $val->getLocation()->getName();
                },
            ))
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