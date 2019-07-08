<?php

namespace NB\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompagnieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', [
                'required' => true
            ])
            ->add('adresse', 'textarea', [
                'required' => true
            ])
            ->add('slogan', 'text', [
                'required' => false
            ])
            ->add('description', 'ckeditor', [
                'required' => false
            ])
            ->add('telephone', 'text', [
                'required' => true
            ])
            ->add('metatitre', 'text', [
                'required' => false
            ])
            ->add('metadescription', 'text', [
                'required' => false
            ])
            ->add('motCle', 'text', [
                'required' => false
            ])
            ->add('commission', 'text', [
                'required' => true
            ])
            ->add('email', 'text', [
                'required' => true
            ])
            ->add('logo', 'file', [
                'required' => false
            ])
            ->add('isActive', 'choice', array(
                'choices' => array(true => 'Oui', false => 'Non'),
                'expanded' => true,
                'multiple' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NB\MainBundle\Entity\Compagnie'
        ));
    }
}
