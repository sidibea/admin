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

class AxesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('source', 'entity', array(
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
            ->add('destination', 'entity', array(
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
            ->add('capacite', 'integer', [
                'required' => false
            ])
            ->add('type', 'choice', array(
                'choices' => array(true => 'Nationale', false => 'Internationale'),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('typeBus', 'choice', array(
                'choices' => array(true => 'Climatisé', false => 'Ordinaire'),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('description', 'ckeditor', array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    'language' => 'fr'
                    //...
                ),
                'required' => false
            ))
            ->add('distance', 'integer', [
                'required' => false
            ])
            ->add('photo', 'file', [
                'required' => false
            ])
            ->add('isActive', 'choice', array(
                'choices' => array(true => 'Oui', false => 'Non'),
                'expanded' => true,
                'multiple' => false
            ))        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NB\MainBundle\Entity\Axes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nb_mainbundle_axes';
    }



}