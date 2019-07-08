<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 5:54 PM
 */

namespace NB\MainBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointEmbarquementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('isActive', 'choice', array(
                'choices' => array(true => 'Oui', false => 'Non'),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('longitude')
            ->add('lattitude')
            ->add('nom')
            ->add('compagnie', 'entity', array(
                'class'    => 'NBMainBundle:Compagnie',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.isActive = :active')
                        ->setParameter('active', true);
                },
                'property' => 'nom',
                'multiple' => false
            ))

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NB\MainBundle\Entity\PointEmbarquement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nb_mainbundle_point_embarquement';
    }



}