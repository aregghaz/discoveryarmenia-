<?php

namespace Config\MediaBundle\Admin;

use Config\MediaBundle\Lib\FileManager;
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

class GalleryAdmin extends Admin
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
            ->add('id', null, array('label' => 'ID'))
            ->addIdentifier('name', null, array('label' => 'Gallery name'))
            ->add('title',null,array('label'=> 'Title'))
            ->add('description',null,array('label'=> 'Description'))
            ->add('File count', null, array('template' => 'ConfigMediaBundle::file_count.html.twig'))
            ->add('_action', 'actions', array('actions' => array(
                'edit' => array(),
                'delete' => array()
            )));
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
        $maxSize = FileManager::getMaxUploadSize() * 1000000;
        $mimeTypes = FileManager::getMimeTypes();

        $formMapper
            ->with('General', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
            ))
            ->add('name')
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'Config\MediaBundle\Entity\Gallery',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                        'required'=>false
                    ),
                    'description'=>array(
                        'field_type'=>'textarea',
                        'required'=>false
                    )
                )
            ))
            ->add('file', 'file', array(
                'attr'=>array(
                    'class'=>'upload hide',

                ),
                'multiple' => true,
                'required'=>false,
                "mapped" => false,
                /*'constraints' => array(
                    new Assert\File(array(
                        'maxSize' => $maxSize,
                        'mimeTypes'=> $mimeTypes,
                        'mimeTypesMessage'=>"The mime type of the file is invalid ({{ type }})"
                    ))
                )*/

            ))
            ->add('enabled')
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
            ->add('id');

    }




}