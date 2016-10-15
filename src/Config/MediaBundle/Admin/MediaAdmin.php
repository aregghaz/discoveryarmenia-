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

class MediaAdmin extends Admin
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
            ->add('Info', null, array('template' => 'ConfigMediaBundle::list_image.html.twig'))
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

        $maxSize = FileManager::getMaxUploadSize() * 1000000;
        $mimeTypes = FileManager::getMimeTypes();
        $contexts = FileManager::getCropImageSettings();
        $context = array();
        foreach ($contexts as $key => $value){
            $context[$key] = $key;
        }

        $file_type = explode('/',$this->getSubject()->getType());
        $formMapper
            ->with('General', array(
                'class'       => 'col-md-9',
                'box_class'   => 'box box-solid box-discover',
            ))
            ->add('realName',null,array('label'=>'Name','required'=>false,'attr'=>array('readonly'=>'readonly')))
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'Config\MediaBundle\Entity\Media',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                        'required'=>false
                    ),
                    'caption'=>array(
                        'field_type'=>'text',
                        'required'=>false
                    ),
                    'description'=>array(
                        'field_type'=>'textarea',
                        'required'=>false
                    )
                )
            ))
            ->add('alt')
            ->end()
            ->with('Media', array(
                'class'       => 'col-md-3',
                'box_class'   => 'box box-solid box-discover',
            ))
            ->add('name',null,array('label'=>'Base Name','required'=>false,'attr'=>array('readonly'=>'readonly')))
            ->add('file','file',array(
                'required'=>true,
                'attr'=>array('class'=>'hasMedia'),
                'constraints' => array(
                    new Assert\File(array(
                        'maxSize' => $maxSize,
                        'mimeTypes'=> $mimeTypes,
                        'mimeTypesMessage'=>"The mime type of the file is invalid ({{ type }})"
                    ))
                )
                )
            )
            ->add('context', 'choice', array(
                'choices' => $context,
                'required' => false,
                'expanded' => false,
                'data' => 'default',
            ))
            ->end()
            ->with('Properties', array(
                'class'       => 'col-md-3',
                'box_class'   => 'box box-solid box-discover',
            ));
            if($file_type[0] == 'image'){
                $formMapper
                    ->add('width','text',array('required'=>false,'attr'=>array('readonly'=>'readonly')))
                    ->add('height','text',array('required'=>false,'attr'=>array('readonly'=>'readonly')));
            }


            $formMapper->add('size','text',array('required'=>false,'attr'=>array('readonly'=>'readonly')))

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
        $types = array(
            "image/png" => "png",
            "image/jpeg" => "jpg",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => "word"
        );
        $datagridMapper
            ->add('name')
            ->add('type','doctrine_orm_choice', array(

                'field_options'=> array(
                    'choices' => $types,
                    'required' => false,
                    'multiple' => true,
                    'expanded' => false,
                ),
                'field_type'=> 'choice',
            ))
            ;

        $providers = array();
        $providerNames = $this->configurationPool->getContainer()->getParameter('config_media.contexts');
        foreach ($providerNames as $key=>$name) {
            $providers[$key] = $key;
        }

        $datagridMapper->add('context', 'doctrine_orm_choice', array(

            'field_options'=> array(
                'choices' => $providers,
                'required' => false,
                'multiple' => true,
                'expanded' => false,
            ),
            'field_type'=> 'choice',
        ));

    }




}