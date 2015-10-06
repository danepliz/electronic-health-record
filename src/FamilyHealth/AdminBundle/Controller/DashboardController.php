<?php

namespace FamilyHealth\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $memberRepo = $this->getDoctrine()->getRepository('FamilyHealthMemberBundle:Member');

        $membersCount = $memberRepo->getMemberCounts();

//        print_r($membersCount);
//
//        die;

        $data['member_counts'] = $membersCount;

        $data['page_title'] = 'Dashboard';
        $data['page_desc'] = 'Home';

        return $this->render('FamilyHealthAdminBundle:Dashboard:index.html.twig', $data);
    }
}
