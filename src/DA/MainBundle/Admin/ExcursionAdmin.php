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

class ExcursionAdmin extends AbstractAdmin
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
            ->addIdentifier('location', null, array('label' => 'Location'))
            ->add('guide', null, array('label' => 'Guide'))
            ->add('ticket', null, array('label' => 'Ticket'))
            ->add('transport', null, array('label' => 'Transport'))
            ->add('duration', null, array('label' => 'Duration (minute)'))
            ->add('price', null, array('label' => 'Price'))
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
            ->with('Excursion', array(
                'class'       => 'col-md-8',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('name')
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Room',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                    ),
                    'description'=>array(
                        'field_type'=>'textarea',
                    )
                )
            ))
            ->end();
        $formMapper->with(' ', array(
            'class'       => 'col-md-4',
            'box_class'   => 'box box-solid box-discover',
            // ...
        ))
            ->add('image', 'sonata_type_model_list', array('required' => false))
            ->add('gallery', 'sonata_type_model_list', array('required' => false))
            ->add('location', 'sonata_type_model_autocomplete', array(
                'property'=>'name',
            ))
            ->add('current_location', 'entity', array(
                'class' => 'DAMainBundle:Location',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->Where('l.category = ?1')
                        ->setParameter('1','excursion');
                },
                'choice_label' => 'name'
            ))
            ->add('guide')
            ->add('ticket')
            ->add('transport')
            ->add('best_price')
            ->add('popular')
            ->add('duration',null,array(
                'label'=>'Duration (minute)'
            ))
            ->add('price')
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