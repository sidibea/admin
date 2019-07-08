<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/3/17
 * Time: 12:11 PM
 */

namespace NB\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatistiquesController extends Controller {

    public function seatsellerAction(){

        return $this->render('NBMainBundle:Statistiques:seatseller.html.twig');
    }

}