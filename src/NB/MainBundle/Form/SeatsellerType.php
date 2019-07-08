<?php

namespace NB\MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeatsellerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('nomAgence')
            ->add('ville', 'entity', array(
                'class'    => 'NBMainBundle:Ville',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->where('v.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('v.nom', 'ASC');
                },
                'property' => 'nom',
                'multiple' => false,
            ))
            ->add('commune', 'entity', array(
                'class'    => 'NBMainBundle:Commune',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('c.nom', 'ASC');
                },
                'property' => 'nom',
                'multiple' => false,
            ))
            ->add('quartier', 'entity', array(
                'class'    => 'NBMainBundle:Quartier',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('q')
                        ->where('q.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('q.nom', 'ASC');
                },
                'property' => 'nom',
                'multiple' => false,
            ))
            ->add('contact')
            ->add('email')
            ->add('numeroNina')
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
            'data_class' => 'NB\MainBundle\Entity\Seatseller'
        ));
    }
}
