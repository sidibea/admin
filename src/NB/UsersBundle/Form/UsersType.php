<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NB\UsersBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsersType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('nomAgence')
            ->add('ville')
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
            ->add('email')
            ->add('numeroNina')
            ->add('nif')
            ->add('mob')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NB\UsersBundle\Entity\Users',
        ));
    }

    public function getName()
    {
        return 'nb_seatseller_add';
    }
}
