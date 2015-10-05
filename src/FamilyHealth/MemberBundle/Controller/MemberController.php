<?php

namespace FamilyHealth\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
