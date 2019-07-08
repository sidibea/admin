<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 3:29 PM
 */

namespace NB\MainBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleEditType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // On ajoute une fonction qui va écouter un évènement
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
            function(FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
                // On récupère notre objet Advert sous-jacent
                $bus = $event->getData();

                // Cette condition est importante, on en reparle plus loin
                if (null === $bus) {
                    return; // On sort de la fonction sans rien faire lorsque $advert vaut null
                }

                if ($bus->getPhoto() != null ) {

                    $event->getForm()->add('photo', 'file', array(
                        'required' => false,
                        'mapped' => false,
                    ));
                }

            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NB\MainBundle\Entity\Ville'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return new VilleType();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nb_mainbundle_ville_edit';
    }

}