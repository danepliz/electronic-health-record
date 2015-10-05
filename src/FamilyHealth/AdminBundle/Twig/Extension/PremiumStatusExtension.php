<?php

namespace FamilyHealth\AdminBundle\Twig\Extension;



class PremiumStatusExtension extends \Twig_Extension{

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('premium_admin_status', array($this, 'premiumAdmin'))
        ];
    }

    public function premiumAdmin($isPremium, $expireDate = NULL)
    {


        $exString = '';

        if( $expireDate ){

            $today = new \DateTime();
            $dateDiff = $today->diff($expireDate);

            $years = $dateDiff->format('%R%y');
            $months = $dateDiff->format('%R%m');
            $days = $dateDiff->format('%R%d');


            if( $years > 0  ){
                $yearDesc = ($years == 1)? 'year' : 'years';
                $exString .= $years .' '.$yearDesc.' ';
            }

            if( $years < 1 and $months > 0  ){
                $monthDesc = ($months == 1)? 'month' : 'months';
                $exString .= $months .' '.$monthDesc.' ';
            }

            if( $months < 1 and $days > 0  ){
                $dayDesc = ($days == 1)? 'day' : 'days';
                $exString .= $days .' '.$dayDesc.' ';
            }
        }

        $out = '';

        if( $isPremium ){
            $statusDesc = ( $exString == '' )? 'Expired Member' : 'Premium Member';
            $statusClass = ( $exString == '' )? 'label-danger' : 'label-success';
        }else{
            $statusDesc = 'Non Premium Member';
            $statusClass = 'label-warning';
        }

        $out .= "<span class=\"label {$statusClass}\">{$statusDesc}</span>";

        if( $exString ){
            $out .= ' <cite>'.substr($exString,1,strlen($exString)).' Remaining</cite>';
        }

        return $out;
    }


    public function getName()
    {
        return 'premium_status';
    }

}