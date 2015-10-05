<?php

namespace FamilyHealth\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MemberType extends AbstractType
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
                    'class' => 'form-control',
                    'data-inputmask' => "'mask' : '(999) 999-9999'"
                ]
            ])
            ->add('hasSurgery', 'choice', [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    '0' => 'NO',
                    '1' => 'YES'
                ]
            ])
            ->add('dob', 'date',
                [
                    'required' => FALSE,
                    'label'=> 'Birth Date',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => ['class' => 'form-control', 'data-format'=> 'yyyy-MM-dd']
                ]
            )
            ->add('bloodGroup','choice', [
                'required' => FALSE,
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    '' => ' -- BLOOD GROUP -- ',
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
            ->add('file', 'file', [
                'required' => FALSE,
                'attr' => ['class' => 'form-control']
            ])
            ->add('address','textarea', ['attr' => ['class' => 'datetime form-control']])
            ->add('joinedDate', 'date',
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => ['class' => 'form-control', 'data-format'=> 'yyyy-MM-dd']
                ]
            )
            ->add('isPremiumMember', 'choice',[
                'label' => 'Is Premium',
                'attr' => [ 'class'=>'form-control' ],
                'choices' => [
                    '0' => 'NO',
                    '1' => 'YES'
                ]
            ])
            ->add('premiumExpiryDate', 'date',
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => 'Premium Expiry Date',
                    'required' => FALSE,
                    'attr' => ['class' => 'form-control', 'data-format'=> 'yyyy-MM-dd']
                ]
            )
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
        return 'familyhealth_adminbundle_member';
    }
}
