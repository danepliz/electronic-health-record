<?php

namespace FamilyHealth\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('FamilyHealthFrontendBundle:Home:index.html.twig',[]);
    }
}
