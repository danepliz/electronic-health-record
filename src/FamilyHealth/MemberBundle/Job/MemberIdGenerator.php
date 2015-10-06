<?php
namespace FamilyHealth\MemberBundle\Job;


use Doctrine\ORM\EntityManager;

class MemberIdGenerator{

    private $em;

    public function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
    }

    public function generateMemberId(){

        $prefix = 'FHN-'.date('Y');
        $memberRepo = $this->em->getRepository('FamilyHealthMemberBundle:Member');
        $nextMemberId = $memberRepo->getNextMemberIdCount($prefix);

        return $nextMemberId;
    }


}