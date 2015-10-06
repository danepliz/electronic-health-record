<?php

namespace FamilyHealth\MedicalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FamilyHealthMedicalBundle:Default:index.html.twig', array('name' => $name));
    }
}
