<?php

namespace FamilyHealth\MemberBundle\Controller;

use FamilyHealth\AdminBundle\Form\MemberType;
use FamilyHealth\MemberBundle\Form\MemberProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $data['user'] = $user;
//        $data['member'] = $user->getMember();
        $mm = $this->getDoctrine()->getRepository('FamilyHealthMemberBundle:Member');
        $data['member'] = $mm->findOneBy(['id' => $user->getMember()->getId()]);
        return $this->render('FamilyHealthMemberBundle:Home:index.html.twig', $data);
    }

    public function updateProfileAction(Request $request){

        $security = $this->get('security.context');
        $user = $security->getToken()->getUser();
        if( ! $this->isGranted('ROLE_MEMBER') ) $this->redirectToRoute('family_health_frontend_homepage');
        $member = $user->getMember();

        if( ! $member ) $this->redirectToRoute('family_health_frontend_homepage');

        $form = $this->createForm(new MemberProfileType(), $member);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $member = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($member);

            try{
                $em->flush();
                $this->addFlash('success', 'Profile Updated Successfully.');
                return $this->redirectToRoute('family_health_member_homepage');
            }catch(\Exception $e){
                $this->addFlash('error', 'Unable to update profile. '.$e->getMessage());
            }

        }

        $data['page_title'] = 'Profile';
        $data['page_desc'] = 'update';
        $data['form'] = $form->createView();
        $data['member'] = $member;
        return $this->render('FamilyHealthMemberBundle:Home:update_profile.html.twig', $data);
    }
}
