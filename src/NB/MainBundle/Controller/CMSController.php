<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 24/02/2017
 * Time: 12:35
 */

namespace NB\MainBundle\Controller;


use NB\MainBundle\Form\TCType;
use NB\MainBundle\Form\PCType;
use NB\MainBundle\Form\ProType;
use NB\MainBundle\Form\MVType;
use NB\MainBundle\Form\AVType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CMSController extends Controller
{
  public function TermesConditionsAction(Request $request){
      $em=$this->getDoctrine()->getManager();
      $tc=$em->getRepository('NBMainBundle:CMS')->find(1);

      $form=$this->get('form.factory')->create(new TCType(),$tc);
      if ($form->handleRequest($request)->isValid()){
          $tc->setUpdatedAt(new \datetime );
          $em->flush();
          return $this->redirect($this->generateUrl('nb_main_termes_et_conditions'));
      }

      return $this->render('NBMainBundle:CMS:TermesConditions.html.twig',array(
          'form'=>$form->createView()
      ));
  }

    public function confidentialiteAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $pc=$em->getRepository('NBMainBundle:CMS')->find(1);

        $form=$this->get('form.factory')->create(new PCType(),$pc);
        if ($form->handleRequest($request)->isValid()){
            $pc->setUpdatedAt(new \datetime );
            $em->flush();
            return $this->redirect($this->generateUrl('nb_main_confidentialite'));
        }

        return $this->render('NBMainBundle:CMS:confidentialite.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    public function professionelAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $pro=$em->getRepository('NBMainBundle:CMS')->find(1);

        $form=$this->get('form.factory')->create(new ProType(),$pro);
        if ($form->handleRequest($request)->isValid()){
            $pro->setUpdatedAt(new \datetime );
            $em->flush();
            return $this->redirect($this->generateUrl('nb_main_professionel'));
        }

        return $this->render('NBMainBundle:CMS:professionel.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    public function ModificationVoyageAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $mv=$em->getRepository('NBMainBundle:CMS')->find(1);

        $form=$this->get('form.factory')->create(new MVType(),$mv);
        if ($form->handleRequest($request)->isValid()){
            $mv->setUpdatedAt(new \datetime );
            $em->flush();
            return $this->redirect($this->generateUrl('nb_main_modification_voyage'));
        }

        return $this->render('NBMainBundle:CMS:ModificationVoyage.html.twig',array(
            'form'=>$form->createView()
        ));
    }


    public function AnnulationVoyageAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $av=$em->getRepository('NBMainBundle:CMS')->find(1);

        $form=$this->get('form.factory')->create(new AVType(),$av);
        if ($form->handleRequest($request)->isValid()){
            $av->setUpdatedAt(new \datetime );
            $em->flush();
            return $this->redirect($this->generateUrl('nb_main_annulation_voyage'));
        }

        return $this->render('NBMainBundle:CMS:AnnulationVoyage.html.twig',array(
            'form'=>$form->createView()
        ));
    }
}