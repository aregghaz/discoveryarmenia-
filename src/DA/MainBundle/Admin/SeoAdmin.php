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

class SeoAdmin extends AbstractAdmin
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
            ->add('title', null, array('label' => 'Title'));
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
            ->add('title', null, array('label' => 'Title'))
            ->add('description', null, array('label' => 'Title'))
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

        $formMapper
            ->with('General', array(
                'class'       => 'col-md-9',
                'box_class'   => 'box box-solid box-danger',
                // ...
            ))
            ->add('title')
            ->add('description','textarea',array('required'=>false))
            ->add('keywords')
            ->add('social_title')
            ->add('social_description','textarea',array('required'=>false))
            ->end()
            ->with('Media', array(
                'class'       => 'col-md-3',
                'box_class'   => 'box box-solid box-danger',
                // ...
            ))
            ->add('social_image', 'sonata_type_model_list', array('required' => false))
            ->add('image_size', 'choice', array(
                'label'=> 'Share image size',
                'choices' => array(
                    1 => '200x200',
                    2 => '400x400'
                ),
                'required' => true,
                'expanded' => true,
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
            ->add('title');
    }

}