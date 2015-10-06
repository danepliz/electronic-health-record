<?php

namespace FamilyHealth\InstitutionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstitutionAdminController extends Controller
{
    public function indexAction()
    {
        $data['institutions'] = [];
        return $this->render('FamilyHealthInstitutionBundle:Admin:index.html.twig', $data);
    }

    public function addAction()
    {



        $data['institutions'] = [];
        return $this->render('FamilyHealthInstitutionBundle:Admin:index.html.twig', $data);
    }





}
