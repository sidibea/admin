<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 8:01 PM
 */

namespace NB\MainBundle\Controller;


use NB\MainBundle\Entity\PointEmbarquement;
use NB\MainBundle\Form\PointEmbarquementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PointController extends Controller
{
    public function listAction(){

        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('NBMainBundle:PointEmbarquement')->findAll();

        return $this->render('NBMainBundle:Points:list.html.twig', [
            'list' => $list
        ]);

    }

    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $point = new PointEmbarquement();
        $form = $this->get('form.factory')->create(new PointEmbarquementType(), $point);

        if ($form->handleRequest($request)->isValid()) {

            $point->setCreatedAt(new \datetime);
            $point->setUpdatedAt(new \datetime);
            $em->persist($point);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La ville bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_des_point_embarquement'));

        }

        return $this->render('NBMainBundle:Points:add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();

        $point =  $em->getRepository('NBMainBundle:PointEmbarquement')->find($id);
        $form = $this->get('form.factory')->create(new PointEmbarquementType(), $point);

        if ($form->handleRequest($request)->isValid()) {

            $point->setUpdatedAt(new \datetime);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La ville bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_des_point_embarquement'));

        }

        return $this->render('NBMainBundle:Points:add.html.twig', [
            'form' => $form->createView()
        ]);

    }

}