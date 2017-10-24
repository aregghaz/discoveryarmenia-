<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Config\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use FOS\UserBundle\Form\Type\RegistrationFormType;

class RegistrationFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'label' => 'form.login',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.login')
            ))
            ->add('company_name', null, array(
                'label' => 'form.company_name',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.company_name')
            ))
            ->add('country', null, array(
                'label' => 'form.country',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.country')
            ))
            ->add('email', 'email', array(
                'label' => 'form.email',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.email')
            ))
            ->add('streetAddress', 'email', array(
                'label' => 'form.streetAddress',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.streetAddress')
            ))
            ->add('city', null, array(
                'label' => 'form.city',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.city')
            ))
            ->add('phone', null, array(
                'label' => 'form.phone',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.phone')
            ))
            ->add('website', null, array(
                'label' => 'form.website',
                'translation_domain' => 'messages',
                'attr'=> array('placeholder'=>'form.website')
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'messages'),
                'first_options' => array('label' => false,'attr'=> array('placeholder'=>'form.password')),
                'second_options' => array('label' => false,'attr'=> array('placeholder'=>'form.password_confirmation')),
                'invalid_message' => 'test' ,
                'label' => false,
                'error_bubbling' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'registration',
        ));
    }

    public function getName()
    {
        return 'lab_user_registration';
    }
}
