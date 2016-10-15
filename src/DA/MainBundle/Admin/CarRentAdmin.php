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

class CarRentAdmin extends AbstractAdmin
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
            ->addIdentifier('name', null, array('label' => 'Model'))
            ->add('type', null, array('label' => 'Type'))
            ->add('door', null, array('label' => 'Door'))
            ->add('transmission', null, array('label' => 'Transmission'))
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
            array('day1_2', 'integer', array(
                'label' => '1-2 Day'
            )),
            array('day3_4', 'integer', array(
                'label' => '3-4 Day'
            )),
            array('day5_6', 'integer', array(
                'label' => '5-6 Day'
            )),
            array('day7_8', 'integer', array(
                'label' => '7-8 Day'
            )),
            array('day9_10', 'integer', array(
                'label' => '9-10 Day'
            )),
            array('day_more', 'integer', array(
                'label' => 'More 10 Day'
            ))
        );
        $formMapper
            ->with('Car rent', array(
                'class'       => 'col-md-6',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('image', 'sonata_type_model_list', array('required' => false))
            ->add('name',null,array('label'=>'Model'))
            ->add('type', 'choice', array(
                'label'=> 'Car type',
                'choices' => array(
                    'sedan' => 'Sedan',
                    '4x4' => '4x4',
                ),
                'required' => true,
                'expanded' => false,
            ))
            ->add('door', 'choice', array(
                'label'=> 'Doors',
                'choices' => array(
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                ),
                'required' => true,
                'expanded' => false,
            ))
            ->add('transmission', 'choice', array(
                'label'=> 'Transmission',
                'choices' => array(
                    'automate' => 'Automate',
                    'mechanical' => 'Mechanical',
                ),
                'required' => true,
                'expanded' => true,
            ))
            ->add('motor', 'choice', array(
                'label'=> 'Motor',
                'choices' => array(
                    'm1_6' => '1.6',
                    'm1_8' => '1.8',
                    'm2_0' => '2.0',
                    'm2_2' => '2.2',
                    'm3_0' => '3.0',
                    'm3_2' => '3.2',
                ),
                'required' => true,
                'expanded' => false,
            ))
            ->end()
            ->with(' ', array(
                'class'       => 'col-md-6',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))

            ->add('price_list','sonata_type_immutable_array', array(
                'required' =>false,
                'label' => 'Price list',
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
            ->add('name');
    }

}