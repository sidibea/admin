<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 3:20 PM
 */

namespace NB\MainBundle\Controller;
use NB\MainBundle\Entity\Ville;
use NB\MainBundle\Form\VilleEditType;
use NB\MainBundle\Form\VilleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class VillesController extends Controller
{
    public function listAction(){

        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('NBMainBundle:Ville')->findAll();



        return$this->render('NBMainBundle:Villes:list.html.twig', [
            'list' => $list
        ]);
    }

    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $ville = new Ville();
        $form = $this->get('form.factory')->create(new VilleType(), $ville);

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

                $ville->setPhoto($photoName);
            }else{
                $ville->setPhoto(null);
            }

            $ville->setCreatedAt(new \datetime);
            $ville->setUpdateAt(new \datetime);
            $em->persist($ville);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La ville bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_liste_des_villes'));

        }

        return$this->render('NBMainBundle:Villes:add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function editAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();

        $ville = $em->getRepository('NBMainBundle:Ville')->find($id);
        $form = $this->get('form.factory')->create(new VilleEditType(), $ville);

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

                $ville->setPhoto($photoName);
            }else{
                $ville->setPhoto($ville->getPhoto());
            }

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La ville a bien ete modifiée.');

            return $this->redirect($this->generateUrl('nb_main_liste_des_villes'));
        }

        return$this->render('NBMainBundle:Villes:edit.html.twig', [
            'form' => $form->createView(),
            'ville' => $ville
        ]);

    }





}