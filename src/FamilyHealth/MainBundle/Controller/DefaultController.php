<?php

namespace FamilyHealth\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FamilyHealthMainBundle:Default:index.html.twig', array('name' => $name));
    }
}
