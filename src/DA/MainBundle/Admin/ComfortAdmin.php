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

class ComfortAdmin extends AbstractAdmin
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
            ->add('category', 'choice', array(
                'label'=> 'Category',
                'choices' => array(
                    1 => 'Bathroom (Ванная комната) (Լոգարան)',
                    2 => 'Bedroom (Спальня) (Ննջարան)',
                    3 => 'Media and Technology (Медиа и Технологии) (Տեխնիկա)',
                    4 => 'Internet (Интернет) (Ինտերնետ)',
                    5 => 'Reception (Стойка регистрации) (Ընդունարան)',
                    6 => 'Overall (Общие) (Ընդհանուր)',
                ),
            ))
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
            ->with('General', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
            ))
            ->add('name')
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Comfort',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'title'=>array(
                        'field_type'=>'text',
                        'required' => false,
                    )
                )
            ))
        ->add('category','choice', array(
            'choices' => array(
                1 => 'Bathroom (Ванная комната) (Լոգարան)',
                2 => 'Bedroom (Спальня) (Ննջարան)',
                3 => 'Media and Technology (Медиа и Технологии) (Տեխնիկա)',
                4 => 'Internet (Интернет) (Ինտերնետ)',
                5 => 'Reseption (Стойка регистрации) (Ընդունարան)',
                6 => 'Overall (Общие) (Ընդհանուր)',
            ),
            'required' => true,
            'expanded' => false,
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
            ->add('name');
    }

}