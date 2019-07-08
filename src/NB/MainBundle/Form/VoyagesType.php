<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 9:59 PM
 */

namespace NB\MainBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyagesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heureDepart', 'time', array(
            ))
            ->add('heureArrivee', 'time', array(
            ))
            ->add('description', 'ckeditor')
            ->add('prix')
            ->add('duree', 'text', [
                'required' => false
            ])
            ->add('isActive', 'choice', array(
                'choices' => array(true => 'Oui', false => 'Non'),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('pointEmbarquement', 'entity', array(
                'class' => 'NBMainBundle:PointEmbarquement',
                'property' => 'nom',
                'multiple' => true
            ))
            ->add('axes', 'entity', array(
                'class'    => 'NBMainBundle:Axes',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('r.nom', 'ASC');
                },
                'property' => 'nom',
                'multiple' => false,
            ))
            ->add('compagnie', 'entity', array(
                'class'    => 'NBMainBundle:Compagnie',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('c.nom', 'ASC');
                },
                'property' => 'nom',
                'multiple' => false,
            ))
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NB\MainBundle\Entity\Voyages'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nb_mainbundle_voyages';
    }

}