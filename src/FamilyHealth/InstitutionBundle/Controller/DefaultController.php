<?php

namespace FamilyHealth\InstitutionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FamilyHealthInstitutionBundle:Default:index.html.twig', array('name' => $name));
    }
}
