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

class PromotionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('axes', 'entity', array(
                'class'    => 'NBMainBundle:Axes',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->where('a.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('a.nom', 'ASC');
                },
                'property' => 'nom',
                'multiple' => false,
            ))
            ->add('montant')
            ->add('photo', 'file', [
                'required' => false
            ])
            ->add('dateDebut', 'text')
            ->add('canal', 'choice', array(
                'choices' => array('web' => 'Site Web', 'seatseller' => 'Seatseller'),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('dateFin', 'text')
            ->add('code')
            ->add('description', 'ckeditor')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NB\MainBundle\Entity\Promotion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nb_mainbundle_promotion';
    }



}