<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/24/17
 * Time: 7:56 PM
 */

namespace NB\MainBundle\Controller;


use NB\MainBundle\Entity\Income;
use NB\MainBundle\Entity\Seatseller;
use NB\MainBundle\Form\SeatsellerType;
use NB\MainBundle\Form\SeatsellerUsersType;
use NB\UsersBundle\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SeatSellerController extends Controller {

    public function listAction(){

        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('NBUsersBundle:Users')->findSeatseller();

        return $this->render('NBMainBundle:Seatseller:list.html.twig', array(
            'list' => $list
        ));
    }


    public function editAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $seatseller = $em->getRepository('NBUsersBundle:Users')->find($id);

        $form = $this->get('form.factory')->create(new UsersType(), $seatseller);

        if($form->handleRequest($request)->isValid()){
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Le seatseller a bien ete modifiée.');

            return $this->redirect($this->generateUrl('nb_main_liste_seatseller'));
        }


        return $this->render('NBMainBundle:Seatseller:edit.html.twig', [
            'form' => $form->createView(),
            'seatseller' => $seatseller
        ]);
    }

    public function usersAction($seatseller_id){

        $em = $this->getDoctrine()->getManager();

        $seatseller = $em->getRepository('NBUsersBundle:Users')->find($seatseller_id);



        return$this->render('NBMainBundle:Seatseller:users.html.twig', [
            'seatseller' => $seatseller,
        ]);

    }

    public function accountAction( $seatseller_id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $seatseller = $em->getRepository('NBUsersBundle:Users')->find($seatseller_id);

        $solde =  $this->get('doctrine.orm.entity_manager')->getRepository('NBMainBundle:Income') ->getStatus($seatseller_id);

        $income = new Income();

        if($request->isMethod('post')){
            $income->setMontant($request->get('montant'));
            $income->setSeatseller($seatseller);
            $income->setDateRecharge(new \datetime);
            $income->setCreatedAt(new \datetime);

            $em->persist($income);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre solde a bien été enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_seatseller_solde_compte',['seatseller_id' => $seatseller_id]));
        }


        return$this->render('NBMainBundle:Seatseller:account.html.twig', [
            'seatseller' => $seatseller,
            'solde' => $solde
        ]);
    }


}