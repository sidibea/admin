<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 12:26 PM
 */

namespace NB\MainBundle\Controller;


use NB\MainBundle\Entity\Axes;
use NB\MainBundle\Entity\Ville;
use NB\MainBundle\Form\AxesEditType;
use NB\MainBundle\Form\AxesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AxesController  extends Controller{

    public function listAction(){

        $user = $this->getUser();


        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('NBMainBundle:Axes')->findAll();



        return$this->render('NBMainBundle:Axes:list.html.twig', [
            'list' => $list
        ]);
    }

    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $axes = new Axes();
        $form = $this->get('form.factory')->create(new AxesType(), $axes);

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

                $axes->setPhoto($photoName);
            }else{
                $axes->setPhoto(null);
            }

            $from = $form->get('source')->getData()->getNom();
            $to = $form->get('destination')->getData()->getNom();

            $nom = $from."-".$to;
            $axes->setNom($nom);

            $axes->setCreatedAt(new \datetime);
            $axes->setUpdatedAt(new \datetime);
            $em->persist($axes);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'L\'axe a bien été enregistré.');
            return $this->redirect($this->generateUrl('nb_main_liste_des_axes'));

        }

        return$this->render('NBMainBundle:Axes:add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function editAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();

        $axes = $em->getRepository('NBMainBundle:Axes')->find($id);
        $form = $this->get('form.factory')->create(new AxesEditType(), $axes);

        if ($form->handleRequest($request)->isValid()) {
            $axes->setUpdatedAt(new \datetime);

            $file = $form->get('photo')->getData();
            if(null === $file){
                $axes->setPhoto($axes->getPhoto());
            }else{
                $extension = $file->guessClientExtension();
                $photo =  md5(uniqid()).".".$extension;

                if(file_exists($this->getParameter('photo_directory').$axes->getPhoto()))
                    $file->move(
                        $this->getParameter('photo_directory'),
                        $photo
                    );

                $axes->setPhoto($photo);

            }
            $from = $form->get('source')->getData()->getNom();
            $to = $form->get('destination')->getData()->getNom();
            $nom = $from."-".$to;
            $axes->setNom($nom);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La route a bien ete modifiée.');

            return $this->redirect($this->generateUrl('nb_main_liste_des_axes'));
        }

        return$this->render('NBMainBundle:Axes:edit.html.twig', [
            'form' => $form->createView(),
            'axes' => $axes
        ]);

    }



}