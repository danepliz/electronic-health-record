<?php

namespace FamilyHealth\MemberBundle\Controller;

use FamilyHealth\MemberBundle\Entity\Member;
use FamilyHealth\MemberBundle\Form\MemberRelationType;
use FamilyHealth\MemberBundle\Form\MemberType;
use FamilyHealth\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class MemberAdminController extends Controller
{
    public function indexAction(Request $request)
    {
//        $get = $request->request->all();
        $filters = $request->query->all();

        $memberRepo = $this->getDoctrine()->getRepository('FamilyHealthMemberBundle:Member');
        $members = $memberRepo->listMembers(NULL, NULL, $filters);

        $data['members'] = $members;
        $data['page_title'] = 'Member';
        $data['page_desc'] = 'list of members';
        $data['filters'] = $filters;
        return $this->render('FamilyHealthMemberBundle:Admin:index.html.twig', $data);
    }


    public function addAction(Request $request){
        $member = NULL;
        $id = $request->get('id');
        $data['page_title'] = 'Add Member';
        if( $id ){
            $member = $this->getDoctrine()->getManager()->find('FamilyHealthMemberBundle:Member',$id);
            if( ! $member ){
                return $this->redirectToRoute('family_health_admin_dashboard');
            }
            $data['page_title'] = 'Add Member | '. ucwords($member->getName());
        }

        $memberForm = $this->createForm(new MemberType(), $member);

        $memberForm->handleRequest($request);

        if ($memberForm->isValid()) {
            $member = $memberForm->getData();

            $date = ( $member->getPremiumExpiryDate() )
                ? $member->getPremiumExpiryDate()->format('Y-m-d')
                :  date('Y-m-d', strtotime('+1 years'));
            $dateString = $date.' 23:59:59';
            $expiryDate = new \DateTime($dateString);
            $member->setPremiumExpiryDate($expiryDate);
//            $member->markAsPremiumMember();

            $member->upload();

            $em = $this->getDoctrine()->getManager();

            if( ! $id ){

                $memberId = $this->container->get('family_health_member.generate_member_id')->generateMemberId();
                $member->setMemberId($memberId);
                $username = strtolower(str_replace('-','',$memberId));
                $email = ($member->getEmail())? $member->getEmail() : $username.'@fhn.com';

                $userManager = $this->get('fos_user.user_manager');
                $user = $userManager->createUser();
                $user->setEnabled(true);
                $user->setName($member->getName());
                $user->setUserName($username);
                $user->setPlainPassword($username);
                $user->addRole('ROLE_MEMBER');
                $user->setEmail($email);
                $user->setMember($member);

                $userManager->updateUser($user);
            }

            $em->persist($member);
            $em->flush();

            return $this->redirectToRoute('family_health_admin_member_list');
        }


        $data['form'] = $memberForm->createView();
        $data['member'] = $member;
        return $this->render('FamilyHealthMemberBundle:Admin:add.html.twig', $data);
    }

    public function detailAction(Request $request){

        $id = $request->get('id');
        if($id == ''){ $this->redirect($this->generateUrl('family_health_admin_dashboard')); }

        $member = $this->getDoctrine()->getManager()->find('FamilyHealthMemberBundle:Member',$id);

        if( ! $member){ $this->redirect($this->generateUrl('family_health_admin_dashboard')); }

        $data['member']= $member;
        $data['page_title'] = 'Member Detail';
        $data['page_desc']= $member->getName();
        return $this->render('FamilyHealthMemberBundle:Admin:detail.html.twig', $data);
    }

    public function addRelationAction(Request $request){
        $memberId = $request->get('member');
        $member = NULL;
        if( $memberId  ){
            $member = $this->getDoctrine()->getManager()->find('FamilyHealthMemberBundle:Member',$memberId);

        }

        if( ! $memberId or ! $member ){
            return $this->redirect($this->generateUrl('family_health_admin_dashboard'));
        }

        $relation = NULL;

        $relationId = $request->get('id');
        if($relationId){
            $relation = $this->getDoctrine()->getManager()->find('FamilyHealthMemberBundle:Member',$relationId);
            if(! $relation){
                return $this->redirect($this->generateUrl('family_health_admin_dashboard'));
            }
        }

        $relationForm = $this->createForm(new MemberRelationType(), $relation);

        $relationForm->handleRequest($request);

        if ($relationForm->isValid()) {
            $relation = $relationForm->getData();
            $relation->setParent($member);
            $em = $this->getDoctrine()->getManager();
            $em->persist($relation);

            $em->flush();

            return $this->redirect($this->generateUrl('family_health_admin_member_detail', ['id'=> $member->getId()]));
        }


        $data['form'] = $relationForm->createView();
        $data['member']= $member;
        $data['page_title'] = 'Member | Add';
        return $this->render('FamilyHealthMemberBundle:Admin:add_member.html.twig', $data);
    }

    public function relationTemplateAction(Request $request){

        if( ! $request->isXmlHttpRequest() ){
            die('No Access Allowed');
        }

        $form = $this->createForm(new MemberType(), NULL);
        $template = $this->renderView('FamilyHealthMemberBundle:Admin:relation_form_template.html.twig', ['form'=>$form->createView()]);


        $response['status']= 'success';
        $response['template'] = $template;
        return new JsonResponse($response);
    }

    public function importXlsAction(Request $request){


        $data = [];

        if( 'POST' == $request->getMethod() ){
            if(isset($_FILES['xls']) and $_FILES['xls']['name'] != ''){
                $validate = $this->validateXls($_FILES['xls']);
                if( $validate['success'] == FALSE ){
                    $data['error'] = $validate['data'];
                }else{
                    $em = $this->getDoctrine()->getManager();
                    try{
                        $em->flush();
                        return $this->redirect($this->generateUrl('family_health_admin_member_import_xls'));
                    }catch(\Exception $e){
                        $data['error'] = $e->getMessage();
                    }
                }

            }else{
                $data['error'] = 'Please select a file to import. Supports xls and xlsx only.';
            }
        }

        return $this->render('FamilyHealthMemberBundle:Admin:import.html.twig', $data);
    }

    public function validateXls($loadedFile){

        $response['success'] = FALSE;
        $response['data'] = [];

        $users = [];
        $userManager = $this->get('fos_user.user_manager');

        $explodedName = explode('.', $loadedFile['name']);
        $extension = $explodedName[count($explodedName) -1 ];

        $allowedExtensions = ['xls', 'xlsx'];

        if( ! in_array(strtolower($extension), $allowedExtensions )) {
            $response['data'] = 'Please upload xls or xlsx format only.';
            return $response;
        }

        $memberExcelObject = $this->get('phpexcel')->createPHPExcelObject($loadedFile['tmp_name']);
        $activeSheet = $memberExcelObject->getSheet(0);

        $rows = $activeSheet->toArray();
        unset($rows[0]);

        if( ! count($rows) ){
            $response['data'] = 'File seems to be empty';
            return $response;
        }

        $errors = [];

        $count = 1;
        foreach($rows as $row){

            $error = [];
            $name = $row[0];
            $dob = $row[1];
            $age = $row[2];
            $gender = $row[3];
            $bloodGroup = $row[4];
            $joinedDate = $row[5];
            $email = $row[6];
            $mobile = $row[7];
            $phone = $row[8];
            $address = $row[9];
            $isPremium = $row[10];
            $expiringDate = $row[11];
            $hasSurgery = $row[12];

            $joiningDate = new \DateTime();

            $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';

            if( $name == '' ){
                $error .= 'Name must be provided.';
            }

            if( !is_numeric($age) ){
                $error[] = 'Age must have numeric value.';
            }

            if( ! in_array($gender, ['male', 'female', 'others']) ){
                $error[] = 'Gender must be male,female or others.';
            }

            $isBloodGroupValid = TRUE;
            if( $bloodGroup != '' and ! in_array(strtolower($bloodGroup), ['a+', 'a-', 'b+', 'b-', 'ab+', 'ab-', 'o+', 'o-']) ){
                $error[] = 'Invalid Blood Group. (a+, a-, b+, b-, ab+, ab-, o+, o-)';
                $isBloodGroupValid = FALSE;
            }

            $birthDate = NULL;
            if( $dob != '' ){
                if( !preg_match($date_regex, $dob) ){
                    $error[] = 'Invalid date format for birth date.(YYYY-MM-DD)';
                }else{
                    $birthDate = new \DateTime($dob);
                }
            }


            if( $joinedDate != '' and !preg_match($date_regex, $joinedDate) ){
                $error[] = 'Invalid date format for joined date.(YYYY-MM-DD)';
            }else{
                $joiningDate = new \DateTime($joinedDate);
            }

            if($email != '' and ! filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error[] = 'Invalid email address.';
            }

            if($isPremium != '' and  ! in_array($isPremium, ['yes', 'no']) ){
                $error[] = 'Is Premium must be yes or no or leave it blank for non premium';
            }

            $expDateCheck = ( $expiringDate != '' )? TRUE : FALSE;
            if( $expiringDate != '' and !preg_match($date_regex, $expiringDate) ){
                $error[] = 'Invalid date format for expiring date.(YYYY-MM-DD)';
                $expDateCheck = FALSE;

            }

            $bGroup = [
                'a+' => 'A+VE',
                'a-' => 'A-VE',
                'b+' => 'B+VE',
                'b-' => 'B-VE',
                'ab+' => 'AB+VE',
                'ab-' => 'AB-VE',
                'o+' => 'O+VE',
                'o-' => 'O-VE',
            ];

            $surgeryStatus = ( $hasSurgery )? TRUE : FALSE;

            $member = new Member();
            $member->setName($name)
                ->setAddress($address)
                ->setAge($age)
                ->setEmail($email)
                ->setGender(strtoupper($gender))
                ->setMobile($mobile)
                ->setPhone($phone)
                ->setJoinedDate($joiningDate)
                ->setHasSurgery($surgeryStatus)
            ;

            if( $birthDate ){
                $member->setDob($birthDate);
            }

            if( $isBloodGroupValid and $bloodGroup != '' ){
                $member->setBloodGroup($bGroup[strtolower($bloodGroup)]);
            }

            $em = $this->getDoctrine()->getManager();

            $toMarkPremium = ($isPremium == strtolower('yes'))? TRUE : FALSE;

            if( $toMarkPremium ){

                if( $expDateCheck ){
                    $date = new \DateTime($expiringDate);
                    $memberExpiringDate = $date->format('Y-m-d');
                }else{
                    $memberExpiringDate = date('Y-m-d', strtotime('+1 years', strtotime($joiningDate->format('Y-m-d'))));
                }

                $memberId = $this->container->get('family_health_member.generate_member_id')->generateMemberId();
                $username = strtolower(str_replace('-','',$memberId));
                $expDate = $memberExpiringDate.' 23:59:59';

                if( $email != '' ){
                    $uRepo = $this->getDoctrine()->getManager()->getRepository('FamilyHealthUserBundle:User');
                    $userExist = $uRepo->findOneBy(['email' => $email]);
                    if( $userExist ){
                        $error[] = 'Member with "'.$email.'" already exists.';
                    }
                }else{
                    $email = $username.'@fhn.com';
                }

                $member->setMemberId($memberId);
                $member->markAsPremiumMember();
                $member->setPremiumExpiryDate(new \DateTime($expDate));
            }else{
                $member->unmarkAsPremiumMember();
            }

            $em->persist($member);

            if( count($error) ){
                $errors[] = [
                    'row' => $count,
                    'error' => $error
                ];
            }else{

                if( $toMarkPremium ){
                    $user = $userManager->createUser();
                    $user->setEnabled(true);
                    $user->setName($member->getName());
                    $user->setUserName($username);
                    $user->setPlainPassword($username);
                    $user->addRole('ROLE_MEMBER');
                    $user->setEmail($email);
                    $user->setMember($member);
                    $users[] = $user;
                }

            }

            $count++;

        }

        $response['success'] = TRUE;
        $optString = '';
        if( count($errors) ){
            $response['success'] = FALSE;
            $optString = '<ul>';
            foreach($errors as $v){
                $optString .= '<li><strong>Row '.$v['row'].'</strong><br/>'.implode('<br />', $v['error']).'</li>';
            }
            $optString .= '</ul>';
        }else{
            if(count($users)){
                foreach($users as $u){
                    $userManager->updateUser($u);
                }
            }
        }
        $response['data'] = $optString;

        return $response;

    }

    public function validateFields($row)
    {
        $formatHeaders = [
            '0' => 'string',    //name
            '1' => 'number',    //age
            '2' => 'string',    //gender
            '3' => 'string',    //blood group
            '4' => 'date',      //joined date
            '5' => 'email',     //email
            '6' => 'string',    //mobile
            '7' => 'string',    //phone
            '8' => 'string',    //address
            '9' => 'string',    //is premium
            '10' => 'date',     //expiring date
        ];
    }

}
