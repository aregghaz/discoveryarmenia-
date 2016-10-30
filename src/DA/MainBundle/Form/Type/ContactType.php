<?php

namespace DA\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text',array(
                'required' => false,
                'label' => 'contact.name',
                'translation_domain' => 'messages'
            ))
            ->add('city', 'text',array(
                'required' => false,
                'label' => 'contact.city',
                'translation_domain' => 'messages'
            ))
            ->add('telephone', 'text',array(
                'required' => false,
                'label' => 'contact.telephone',
                'translation_domain' => 'messages'
            ))
            ->add('email', 'email',array(
                'required' => true,
                'label' => 'contact.email',
                'translation_domain' => 'messages'
            ))
            ->add('message', 'textarea',array(
                'required' => false,
                'label' => 'contact.message',
                'translation_domain' => 'messages'
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $collectionConstraint = new Collection(array(
            'name' => array(
                new NotBlank(array('message' => 'Name should not be blank.')),
                new Length(array('min' => 2))
            ),
            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.')),
                new Email(array('message' => 'Invalid email address.'))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}