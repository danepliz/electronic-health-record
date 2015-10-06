<?php

namespace FamilyHealth\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MemberRelationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',
                [
                    'attr' => ['class' => 'form-control'],
                    'required'=> true
                ]
            )
            ->add('age','text', ['attr' => ['class' => 'datetime form-control']])
            ->add('gender','choice', [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'MALE' => 'Male',
                    'FEMALE' => 'Female',
                    'OTHERS' => 'Others'
                ]
            ])
            ->add('email','email',
                [
                    'attr' => ['class' => 'form-control'],
                    'required'=> false
                ]
            )
            ->add('phone','text',
                [
                    'attr' => ['class' => 'form-control'],
                    'required'=> false
                ]
            )
            ->add('mobile','text', [
                'attr' => [
                    'class' => 'datetime form-control',
                    'data-inputmask' => "'mask' : '(999) 999-9999'"
                ]
            ])
            ->add('relation','text', [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])

//            ->add('memberId')
            ->add('bloodGroup','choice', [
                'attr' => ['class' => 'datetime form-control'],
                'choices' => [
                    'A+VE' => 'A +',
                    'A-VE' => 'A -',
                    'AB+VE' => 'AB +',
                    'AB-VE' => 'AB -',
                    'B+VE' => 'B +',
                    'B-VE' => 'B -',
                    'O+VE' => 'O +',
                    'O-VE' => 'O -',
                ]
            ])
            ->add('address','textarea', ['attr' => ['class' => 'datetime form-control']])
//            ->add('joinedDate', 'date',
//                [
//                    'widget' => 'single_text',
//                    'format' => 'yyyy-MM-dd',
//                    'attr' => ['class' => 'form-control', 'data-format'=> 'yy-MM-dd']
//                ]
//            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FamilyHealth\MemberBundle\Entity\Member'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'familyhealth_adminbundle_member_relation';
    }
}
