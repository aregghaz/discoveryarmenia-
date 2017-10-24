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

class LocationAdmin extends AbstractAdmin
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
            ->add('name', null, array('label' => 'Title'));
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
            ->with('Location', array(
                'class'       => 'col-md-6',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('name')
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Location',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                        'attr'=>array('class'=>'test'),
                    )
                )
            ))
            ->add('latitude', 'number', array(
                'label' => 'Latitude',
                'required' => false,
                'precision' => 7,
                'attr' => array(
                    'class' => 'lat',
                    'readonly' => true,
                    'data-lt' => $this->getSubject()->getLatitude()
                ),
            ))
            ->add('longitude', 'number', array(
                'label' => 'Longitude',
                'required' => false,
                'precision' => 7,
                'attr' => array(
                    'class' => 'lng',
                    'readonly' => true,
                    'data-lng' => $this->getSubject()->getLongitude(),
                ),
            ))
            ->add('category', 'choice', array(
                'label'=> 'Location Category',
                'choices' => array(
                    'city' => 'City',
                    'hotel' => 'Hotel',
                    'apartment' => 'Apartment',
                    'villa' => 'Villa',
                    'excursion' => 'Excursion',
                ),
                'required' => true,
                'expanded' => false,
            ))
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
            ->add('name');
    }

}