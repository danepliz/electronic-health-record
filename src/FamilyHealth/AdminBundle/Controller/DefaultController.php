<?php

namespace FamilyHealth\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('FamilyHealthAdminBundle:Default:index.html.twig', array());
    }
}
