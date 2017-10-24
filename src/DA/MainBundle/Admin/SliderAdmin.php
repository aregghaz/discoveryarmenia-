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

class SliderAdmin extends AbstractAdmin
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
            ->with('Slider', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover armenia_block_admin',
                // ...
            ))
            ->add('name',null,array(
                'required' => true,
            ))
            ->add('slide', 'sonata_type_collection', array(
                'label' => 'Add Slide',
                'required' => false,
                'by_reference' => false,
                'type_options' => array('delete' => true)

            ), array(
                'data_class' => 'DA\MainBundle\Entity\Slide',
                'admin_code' => 'slide.admin',
                'edit' => 'inline',
                //'inline' => 'table',

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