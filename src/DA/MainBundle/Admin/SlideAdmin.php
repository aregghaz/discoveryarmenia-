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

class SlideAdmin extends AbstractAdmin
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
            ->addIdentifier('name', null, array('label' => 'Name'))
            ->add('slug', 'string', array(
                    'label' => 'Link',
                    'template' => 'ConfigAdminBundle:Templates:link.html.twig')
            )
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
            ->with('Page', array(
                'class'       => 'col-md-7',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('name',null,array(
                'required' => true,
            ))
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Page',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                        'required' => false,
                    ),
                    'description'=>array(
                        'field_type'=>'textarea',
                        'required' => false,
                    ),
                    'url_title'=>array(
                        'field_type'=>'text',
                        'required' => false,
                    )
                )
            ))
            ->add('url')
            ->add('position')
            ->end();
        $formMapper->with('Media', array(
            'class'       => 'col-md-5',
            'box_class'   => 'box box-solid box-discover',
            // ...
        ))
        ->add('image', 'sonata_type_model_list', array('required' => false))
        ->add('icon', 'sonata_type_model_list', array('required' => false))
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