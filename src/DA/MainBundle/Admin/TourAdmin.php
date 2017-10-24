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

class TourAdmin extends AbstractAdmin
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
            ->add('tour_name', null, array('label' => 'Title'));
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
            ->addIdentifier('day_count', null, array('label' => 'Days'))
            ->addIdentifier('tour_name', null, array('label' => 'Name'))
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
            ->with('Tour', array(
                'class'       => 'col-md-8',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('tour_name', 'sonata_type_model_autocomplete', array(
                'property'=>'name',
            ))
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Tour',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'description'=>array(
                        'field_type'=>'textarea',
                        'required' => false,
                    ),
                    'info'=>array(
                        'field_type'=>'textarea',
                        'required' => false,
                    )
                )
            ))

            ->end()
            ->with(' ', array(
                'class'       => 'col-md-4',
                'box_class'   => 'box box-solid box-discover armenia_block_admin',
            ))
            ->add('image', 'sonata_type_model_list', array('required' => false))
            ->add('price')
            ->add('location', null, array(
                'label'=> 'Add location',
                'required' => false,
                'multiple'=>true
            ))
            ->add('day_count')
            ->add('night_count')
            ->add('weekend')
            ->add('best_tour')
            ->end()
            ->with('Days', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover armenia_block_admin day_block_admin',
            ))
                ->add('day_block','sonata_type_collection', array(
                    'label' => false,
                    'required' => false,
                    'by_reference' => false,
                    'type_options' => array('delete' => true)
    
                ), array(
                    'data_class' => 'Travel\MainBundle\Entity\DayBlock',
                    'admin_code' => 'tour.block.admin',
                    'edit' => 'inline',
                    'template' => 'MyBundle:Form:slides.admin.html.twig'
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
//        $datagridMapper
//            ->add('tour_name');
    }

}