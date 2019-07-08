<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 22/02/2017
 * Time: 17:14
 */

namespace NB\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
     public function indexAction(){
         return $this->render('NBMainBundle::index.html.twig');
     }
}