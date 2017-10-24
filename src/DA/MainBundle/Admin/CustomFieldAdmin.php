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

class CustomFieldAdmin extends AbstractAdmin
{
    
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
                'class'       => 'col-md-9',
                'box_class'   => 'box box-solid box-danger',
                // ...
            ))
            ->add('translations', 'a2lix_translations_gedmo', array(
                'translatable_class' => 'DA\MainBundle\Entity\CustomField',
                'by_reference' => false,
                'label' => false,
                'locales' => array_keys($languages),
                'fields'=>array(
                    'key'=>array(
                        'field_type'=>'text',
                        'label'=>'Text'
                    ),
                    'value'=>array(
                        'field_type'=>'text',
                        'label'=>'Text'
                    )
                )
            ))
            ->end();
    }
    
}