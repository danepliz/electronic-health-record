<?php

namespace FamilyHealth\InstitutionBundle\Controller;

use FamilyHealth\InstitutionBundle\Form\InstitutionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InstitutionAdminController extends Controller
{
    public function indexAction()
    {

        $repo = $this->getDoctrine()->getRepository('FamilyHealthInstitutionBundle:Institution');
        $institutions = $repo->findBy([],['name' => 'ASC']);

        $data['page_title'] = 'Institution';
        $data['page_desc'] = 'List';
        $data['institutions'] = $institutions;
        return $this->render('FamilyHealthInstitutionBundle:Admin:index.html.twig', $data);
    }

    public function addAction(Request $request)
    {
        $id = $request->get('id');

        $data['page_title'] = 'Institution';
        $data['page_desc'] = 'Add';
        $successMessage = 'Institution Added Successfully.';
        $institution = NULL;

        if( $id ){
            $institution = $this->getDoctrine()->getRepository('FamilyHealthInstitutionBundle:Institution')->find($id);
            if( ! $institution ){
                $this->redirectToRoute('family_health_admin_institution_list');
            }

            $successMessage = 'Institution Updated Successfully.';
            $data['page_desc'] = $institution->getName();
        }

        $form = $this->createForm(new InstitutionType(), $institution);

        $form->handleRequest($request);

        if( $form->isValid() ){
            $institution = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($institution);

            try{
                $em->flush();
                $this->addFlash('success', $successMessage);
                return $this->redirectToRoute('family_health_admin_institution_list');
            }catch (\Exception $e){
                $this->addFlash('error', 'Something went wrong. '.$e->getMessage());
            }
        }

        $data['form'] = $form->createView();
        return $this->render('FamilyHealthInstitutionBundle:Admin:add.html.twig', $data);
    }





}
