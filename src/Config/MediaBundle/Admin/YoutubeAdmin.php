<?php

namespace Config\MediaBundle\Admin;

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

class YoutubeAdmin extends AbstractAdmin
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
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'Config\MediaBundle\Entity\Youtube',
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
                        'required'=>false,
                        'attr'=>array('class'=>'before_video'),
                    )
                )
            ))
            ->end()
            ->with('Properties', array(
                'class'       => 'col-md-3',
                'box_class'   => 'box box-solid box-danger',
            ))
            ->add('name',null,array('label'=>'Name','required'=>false/*'attr'=>array('readonly'=>'readonly')*/))
            ->add('video_id',null,array('label'=>'Video ID  or  URL','required'=>false))
            ->add('autohide', 'choice', array(
                'data'=>2,
                'choices' => array(
                    2=> 'hide after play',
                    0=> 'show',
                    1=> 'hide'
                ),
                'required' => false,
                'expanded' => false,
            ))
            ->add('iv_load_policy', 'choice', array(
                'choices' => array(
                    1,
                    3
                ),
                'required' => false,
                'expanded' => false,
            ))
            ->add('width')
            ->add('height')
            ->add('start',null,array('required' => false,'label'=>'Start (seconds)'))
            ->add('end',null,array('required' => false,'label'=>'End (seconds)'))
            ->add('controls',null,array('required' => false,'label'=>'Controls (show/hide)'))
            ->add('autoplay',null,array('required' => false,'label'=>'Autoplay (show/hide)'))
            ->add('showinfo',null,array('required' => false,'label'=>'Show info (show/hide)'))
            ->add('modestbranding',null,array('label'=>'Youtube icon (show/hide)'))
            ->add('fs',null,array('label'=>'Full screen icon (show/hide)'))
            ->add('loop_video',null,array('required' => false,'label'=>'Infinity loop'))
            ->add('enabled')
            ->add('background', 'sonata_type_model_list', array('required' => false))
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