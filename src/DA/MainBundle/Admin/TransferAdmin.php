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

class TransferAdmin extends AbstractAdmin
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
            ->addIdentifier('direction', null, array('label' => 'Direction'))
            ->add('types', null, array(
                'label' => 'Price list',
                'template' => 'ConfigAdminBundle:Templates:array.html.twig'
                ))
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
        $priceList = array(
            array('standart1_3', 'integer', array(
                'label' => 'Standart 1-3'
            )),
            array('standart4_8', 'integer', array(
                'label' => 'Standart 4-8'
            )),
            array('luxe1_3', 'integer', array(
                'label' => 'Luxe 1-3'
            )),
            array('luxe1_7', 'integer', array(
                'label' => 'Luxe 1-7'
            )),
            array('luxe1_18', 'integer', array(
                'label' => 'Luxe 1-18'
            ))
        );
        $formMapper
            ->with('Transfer', array(
                'class'       => 'col-md-8',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Room',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'direction'=>array(
                        'field_type'=>'text',
                    )
                )
            ))
            ->end()
            ->with('Price list', array(
                'class'       => 'col-md-4',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('types','sonata_type_immutable_array', array(
                'required' =>false,
                'label' => false,
                'keys' => $priceList
            ))
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
            ->add('direction');
    }

}