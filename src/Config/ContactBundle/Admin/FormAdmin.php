<?php

namespace Config\ContactBundle\Admin;

use Config\MediaBundle\Lib\FileManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints as Assert;

class FormAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC', // sort direction
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
            ->add('id')
            ->addIdentifier('title')
            ->add('name')
            ->add('_action', 'actions', array('actions' => array(
                'edit' => array(),
                'delete' => array()
            )))


        ;
    }

    /**
     * Row form edit configuration
     *
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $languages = $this->configurationPool->getContainer()->getParameter('languages');

        $formMapper

            ->tab('Message', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-info',
                // ...
            ))

                ->with('Message', array(
                    'class'       => 'col-md-12',
                    'box_class'   => ' box-info',
                ))
                    ->add('title',null,array('required'=>true,'label'=>'Title'))
                    ->add('name',null,array('required'=>false,'label'=>'Form ID','attr'=>array('readonly'=>'readonly')))
                    ->add('from')
                    ->add('to', 'text',array('attr'=>array('class'=>'tokenfield')))
                    ->add('subject')
                    ->add('translations', 'a2lix_translations_gedmo', array(
                        'translatable_class' => 'Config\MediaBundle\Entity\Form',
                        'by_reference' => false,
                        'label' => false,
                        'locales' => array_keys($languages),
                        'fields'=>array(
                            'message'=>array(
                                'field_type'=>'textarea',
                                'required'=>false
                            )
                        )
                    ))
                    ->add('attach', 'sonata_type_model_list', array('required' => false))
                    ->add('company_logo', 'sonata_type_model_list', array('required' => false))
                    ->add('html')
                ->end()
            ->end()
            ->tab('Form', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-info',
                // ...
            ))
                ->with('Form', array(
                    'class'       => 'col-md-12',
                    'box_class'   => 'adminForm',
                ))
                    ->add('input','sonata_type_collection', array(
                        'label' => false,
                        'required' => false,
                        'by_reference' => false,
                        'type_options' => array('delete' => true)

                    ), array(
                        'data_class' => 'Config\ContactBundle\Entity\Input',
                        'admin_code' => 'config.contact.input.admin',
                        'edit' => 'inline',
                        'inline' => 'table',

                    ))
                ->end()
            ->end()
            ->tab('Options', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-info',
                // ...
            ))
                ->with('1', array(
                    'class'       => 'col-md-4',
                    'box_class'   => 'adminForm',
                ))
                    ->add('group_class')
                    ->add('input_class')

                ->end()
                ->with('2', array(
                    'class'       => 'col-md-4',
                    'box_class'   => 'adminForm',
                ))
                    ->add('novalidate')
                ->end()
            ->end()


        ;
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
            ->add('name')
        ;


    }




}