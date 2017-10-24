<?php

namespace Config\ContactBundle\Admin;

use Config\MediaBundle\Lib\FileManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints as Assert;

class InputAdmin extends AbstractAdmin
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
            ->with('General', array(
                'class'       => 'col-md-9',
                'box_class'   => 'box box-solid box-danger',
            ))
            ->add('name',null,array('required'=>true))
            ->add('type', 'choice', array(
                'label'=> 'Menu Category',
                'choices' => array(
                    'text' => 'text',
                    'textarea' => 'textarea',
                    'email' => 'email',
                    'radio' => 'radio',
                    'checkbox' => 'checkbox',
                    'tel' => 'tel',
                    'captcha' => 'captcha',
                ),
                'required' => true,
            ))
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'Config\MediaBundle\Entity\Input',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'label'=>array(
                        'field_type'=>'text',
                        'required'=>false
                    ),
                    'placeholder'=>array(
                        'field_type'=>'text',
                        'required'=>false
                    )
                )
            ))
            ->add('disabled')
            ->add('multiple')
            ->add('readonly')
            ->add('required')
            ->add('value')
            ->add('order')
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