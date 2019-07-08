<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/22/17
 * Time: 6:56 PM
 */

namespace NB\MainBundle\Controller;


use NB\MainBundle\Entity\Compagnie;
use NB\MainBundle\Form\CompagnieEditType;
use NB\MainBundle\Form\CompagnieType;
use NB\MainBundle\Form\CompanyUsersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompagnieController extends Controller{

    public function listAction(){

        $list = $this->getDoctrine()->getRepository('NBMainBundle:Compagnie')->findAll();

        return $this->render('NBMainBundle:Compagnie:list.html.twig', [
            'list' => $list
        ]);
    }

    public function addAction(Request $request){
        //déclaration du gestion d'entité pour acceder à la base de donnée
        $em = $this->getDoctrine()->getManager();
        //initialisation de la classe compagnie
        $compagnie = new Compagnie();

        // Creation du formulaire d'insertion de la compagnie
        $form = $this->get('form.factory')->create(new CompagnieType(), $compagnie);

        // Si le formulaire est soumi et que le formulaire est valide
        if ($form->handleRequest($request)->isValid()) {

            // on recupere le logo du formulaire
            $logo = $form->get('logo')->getData();

            // si le logo a ete selectionne alors
            if($logo != null){
                //change le nom d'origine en format md5
                $logoName = md5(uniqid()).'.'.$logo->guessExtension();

                //Transfer le fichier dans le repertoire ou le logo doit etre stocker
                $logo->move(
                    $this->getParameter('logo_directory'),
                    $logoName
                );

                $compagnie->setLogo($logoName);
            }else{
                $compagnie->setLogo(null);

            }

            $compagnie->setCreatedAt(new \datetime);
            $compagnie->setUpdatedAt(new \datetime);
            $em->persist($compagnie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La compagnie bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_des_compagnie'));
        }


        return $this->render('NBMainBundle:Compagnie:add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function editAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();

        $compagnie = $em->getRepository('NBMainBundle:Compagnie')->find($id);
        $form = $this->get('form.factory')->create(new CompagnieEditType(), $compagnie);

        if ($form->handleRequest($request)->isValid()) {
            $compagnie->setUpdatedAt(new \datetime);

            $file = $form->get('logo')->getData();
            if(null === $file){
                $compagnie->setLogo($compagnie->getLogo());
            }else{
                $extension = $file->guessClientExtension();
                $logo =  md5(uniqid()).".".$extension;

                $file->move(
                    $this->getParameter('logo_directory'),
                    $logo
                );

                $compagnie->setLogo($logo);


            }
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La a bien ete modifiée.');

            return $this->redirect($this->generateUrl('nb_main_liste_des_compagnie'));
        }

        return $this->render('NBMainBundle:Compagnie:edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function deleteAction($id){

        $em = $this->getDoctrine()->getEntityManager();
        $compagnie = $em->getRepository('NBMainBundle:Compagnie')->find($id);
        $em->remove($compagnie);
        $em->persist($compagnie);
        $em->flush();

        return $this->redirect($this->generateUrl('nb_main_liste_des_compagnie'));

    }

    public function usersAction($compagnie_id){

        $em = $this->getDoctrine()->getManager();

        $compagnie = $em->getRepository('NBMainBundle:Compagnie')->find($compagnie_id);


        return $this->render('NBMainBundle:Compagnie:users.html.twig', [
            'compagnie' => $compagnie,

        ]);

    }

    public function usersAddAction($compagnie_id, Request $request){

        $em = $this->getDoctrine()->getManager();

        $compagnie = $em->getRepository('NBMainBundle:Compagnie')->find($compagnie_id);
        $form = $this->get('form.factory')->create(new CompanyUsersType(), $compagnie);

        if ($form->handleRequest($request)->isValid()) {

            $compagnie->setUpdatedAt(new \datetime);

            foreach ($compagnie->getUsers() as $users) {
                $users->setRoles(array('ROLE_COMPANY'));
                $users->setEnabled(true);
            }

            $em->persist($compagnie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La compagnie bien enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_utilisateur_compagnie', ['compagnie_id' => $compagnie_id]));
        }

        return $this->render('NBMainBundle:Compagnie:addusers.html.twig', [
            'company' => $compagnie,
            'form' => $form->createView()
        ]);

    }




}