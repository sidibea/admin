<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/24/17
 * Time: 10:57 AM
 */

namespace NB\MainBundle\Controller;


use NB\MainBundle\Entity\Promotion;
use NB\MainBundle\Form\PromotionEditType;
use NB\MainBundle\Form\PromotionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PromotionsController extends Controller {

    public function listAction(){

        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('NBMainBundle:Promotion')->findAll();

        return $this->render('NBMainBundle:Promotions:list.html.twig', [
            'list' => $list
        ]);

    }

    public function addAction(\Symfony\Component\HttpFoundation\Request $request){
        $em = $this->getDoctrine()->getManager();

        $promotion = new Promotion();
        $form = $this->get('form.factory')->create(new PromotionType(), $promotion);

        if ($form->handleRequest($request)->isValid()) {

            $photo = $form->get('photo')->getData();
            $date_debut = $form->get('dateDebut')->getData();
            $date_fin = $form->get('dateFin')->getData();

            if($photo != null){
                // Genere un nom unique du fichier avant le stocker
                $photoName = md5(uniqid()).'.'.$photo->guessExtension();

                //Transfer le fichier dans le repertoire ou le logo doit etre stocker
                $photo->move(
                    $this->getParameter('photo_directory'),
                    $photoName
                );

                $promotion->setPhoto($photoName);
            }else{
                $promotion->setPhoto(null);
            }

            $promotion->setDateDebut(new \DateTime($date_debut));
            $promotion->setDateFin(new \DateTime($date_fin));

            $promotion->setCreatedAt(new \datetime);
            $promotion->setUpdatedAt(new \datetime);

            $em->persist($promotion);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La promotion bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_gestion_des_promotions'));

        }

        return $this->render('NBMainBundle:Promotions:add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function editAction($id, \Symfony\Component\HttpFoundation\Request $request){

        $em = $this->getDoctrine()->getManager();

        $promotion = $em->getRepository('NBMainBundle:Promotion')->find($id);
        $form = $this->get('form.factory')->create(new PromotionEditType(), $promotion);

        if ($form->handleRequest($request)->isValid()) {

            $photo = $form->get('photo')->getData();

            if($photo != null){
                // Genere un nom unique du fichier avant le stocker
                $photoName = md5(uniqid()).'.'.$photo->guessExtension();

                //Transfer le fichier dans le repertoire ou le logo doit etre stocker
                $photo->move(
                    $this->getParameter('photo_directory'),
                    $photoName
                );

                $promotion->setPhoto($photoName);
            }else{
                $promotion->setPhoto($promotion->getPhoto());
            }

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La ville a bien ete modifiée.');

            return $this->redirect($this->generateUrl('nb_main_liste_gestion_des_promotions'));
        }

        return$this->render('NBMainBundle:Promotions:edit.html.twig', [
            'form' => $form->createView(),
            'promotion' => $promotion
        ]);

    }

}