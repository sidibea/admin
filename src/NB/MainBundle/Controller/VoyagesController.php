<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 9:29 PM
 */

namespace NB\MainBundle\Controller;


use NB\MainBundle\Entity\Voyages;
use NB\MainBundle\Form\VoyagesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

class VoyagesController extends Controller {

    public function listAction(){

        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('NBMainBundle:Voyages')->findAll();

        return $this->render('NBMainBundle:Voyages:list.html.twig', [
            'list' => $list
        ]);

    }

    public function addAction(\Symfony\Component\HttpFoundation\Request $request){
        $em = $this->getDoctrine()->getManager();

        $voyages = new Voyages();
        $form = $this->get('form.factory')->create(new VoyagesType(), $voyages);

        if ($form->handleRequest($request)->isValid()) {

            $voyages->setCreatedAt(new \datetime);
            $voyages->setUpdatedAt(new \datetime);
            $em->persist($voyages);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La ville bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_des_voyages'));

        }

        return $this->render('NBMainBundle:Voyages:add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function editAction($id, \Symfony\Component\HttpFoundation\Request $request){
        $em = $this->getDoctrine()->getManager();

        $voyages = $em->getRepository('NBMainBundle:Voyages')->find($id);
        $form = $this->get('form.factory')->create(new VoyagesType(), $voyages);

        if ($form->handleRequest($request)->isValid()) {

            $voyages->setUpdatedAt(new \datetime);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le voyage bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_des_voyages'));

        }

        return $this->render('NBMainBundle:Voyages:add.html.twig', [
            'form' => $form->createView()
        ]);

    }





}