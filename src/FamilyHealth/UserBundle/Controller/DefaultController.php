<?php

namespace FamilyHealth\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FamilyHealthUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
