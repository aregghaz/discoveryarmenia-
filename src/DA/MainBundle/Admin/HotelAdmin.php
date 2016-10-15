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

class HotelAdmin extends AbstractAdmin
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
            ->addIdentifier('name', null, array('label' => 'Hotel'))
            ->addIdentifier('location', null, array('label' => 'Location'))
            ->add('star', 'choice', array(
                'label'=> 'Stars',
                'choices' => array(
                    1 => '⋆',
                    2 => '⋆ ⋆ ',
                    3 => '⋆ ⋆ ⋆',
                    4 => '⋆ ⋆ ⋆ ⋆',
                    5 => '⋆ ⋆ ⋆ ⋆ ⋆',
                    6 => '⋆ ⋆ ⋆ ⋆ ⋆ ⋆',
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

        $em = $this->modelManager->getEntityManager('DA\MainBundle\Entity\Comfort');

        $qb = $em->createQueryBuilder();
        
        $qb = $qb->add('select', 'u.id,u.name')
            ->add('from', 'DA\MainBundle\Entity\Comfort u');

        $query = $qb->getQuery();
        $arrayType = $query->getArrayResult();

        $comfort = array();
        foreach ($arrayType as $key => $value){
            $comfort[$arrayType[$key]['id']] = $arrayType[$key]['name'];
        }
        $formMapper
            ->tab('Hotel', array(
            ))
            ->with('Hotel', array(
                'class'       => 'col-md-8',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->add('name')
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\Hotel',
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
                    'short_description'=>array(
                        'field_type'=>'textarea',
                        'required' => false,
                    )
                )
            ))

            ->end();
            $formMapper->with(' ', array(
                'class'       => 'col-md-4',
                'box_class'   => 'box box-solid box-discover',
            ))
            ->add('image', 'sonata_type_model_list', array('required' => false))
            ->add('gallery', 'sonata_type_model_list', array('required' => false))
            ->add('location', 'sonata_type_model_autocomplete', array(
                'property'=>'name',
            ))
           /* ->add('comfort', null, array(
                'label'=> 'Add Comfort',
                'required' => false,
                'multiple'=>true
            ))*/
            ->add('star', 'choice', array(
                'label'=> 'Stars',
                'choices' => array(
                    1 => '⋆',
                    2 => '⋆ ⋆ ',
                    3 => '⋆ ⋆ ⋆',
                    4 => '⋆ ⋆ ⋆ ⋆',
                    5 => '⋆ ⋆ ⋆ ⋆ ⋆',
                    6 => '⋆ ⋆ ⋆ ⋆ ⋆ ⋆',
                ),
                'required' => true,
                'expanded' => false,
            ))
            ->end()
            ->end();
            $formMapper ->tab('Rooms', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->with('Room', array(
                'class'       => 'col-md-12 ',
                'box_class'   => 'box box-solid box-discover room_admin_block',
            ))
            ->add('room', 'sonata_type_collection', array(
                'label' => false,
                'required' => false,
                'by_reference' => false,
                'type_options' => array('delete' => true)

            ), array(
                'data_class' => 'DA\MainBundle\Entity\Room',
                'admin_code' => 'room.admin',
                'edit' => 'inline',
                //'inline' => 'table',

            ))
            ->end()
            ->end()
            ->tab('Comfort', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-discover',
                // ...
            ))
            ->with('Comforts', array(
                'class'       => 'col-md-12 ',
                'box_class'   => 'box box-solid box-discover room_admin_block',
            ))

            //->add('comfort', 'sonata_type_model', array('multiple' => true, 'by_reference' => false))
            ->add('comfort', 'entity',
                array(
                    'class' => 'DAMainBundle:Comfort',
                    'property' => 'name',
                    'required' => false,
                    'attr'=> array(
                        'class'=> 'list_comfort'
                    ),
                    'multiple' => true,
                    'expanded' => true,
                    'group_by' => function($val, $key, $index) {
                        switch ($val->getCategory()){
                            case 1 :
                                return 'Bathroom (Ванная комната) (Լոգարան)';
                            break;
                            case 2 :
                                return 'Bedroom (Спальня) (Ննջարան)';
                            break;
                        }
                    },
                )
            )
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
            ->add('name')
            ->add('star',null, array(), 'choice', array(
                 'choices' => array(
                        1 => '⋆',
                        2 => '⋆ ⋆ ',
                        3 => '⋆ ⋆ ⋆',
                        4 => '⋆ ⋆ ⋆ ⋆',
                        5 => '⋆ ⋆ ⋆ ⋆ ⋆',
                        6 => '⋆ ⋆ ⋆ ⋆ ⋆ ⋆',
                    )
            ))
        ;
    }

}