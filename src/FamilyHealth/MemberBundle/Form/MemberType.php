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
            ->add('firstName','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'First Name'
                    ],
                    'required'=> true
                ])
            ->add('middleName','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Middle Name'
                    ],
                    'required'=> false
                ])
            ->add('lastName','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Last Name'
                    ],
                    'required'=> true
                ])

            ->add('permanentAddressHouseNumber','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'house no'
                    ],
                    'required'=> false
                ])
            ->add('permanentAddressTole','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'tole'
                    ],
                    'required'=> false
                ])
            ->add('permanentAddressWard','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'ward'
                    ],
                    'required'=> true
                ])
            ->add('permanentAddressVDC','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'mp/vdc'
                    ],
                    'required'=> true
                ])
            ->add('permanentAddressDistrict','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'district'
                    ],
                    'required'=> true
                ])

            ->add('temporaryAddressHouseNumber','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'house no'
                    ],
                    'required'=> false
                ])
            ->add('temporaryAddressTole','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'tole'
                    ],
                    'required'=> false
                ])
            ->add('temporaryAddressWard','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'ward'
                    ],
                    'required'=> false
                ])
            ->add('temporaryAddressVDC','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'mp/vdc'
                    ],
                    'required'=> false
                ])
            ->add('temporaryAddressDistrict','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'district'
                    ],
                    'required'=> false
                ])
            ->add('temporaryAddressPhone','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'phone'
                    ],
                    'required'=> false
                ])
            ->add('permanentAddressPhone', 'text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'phone'
                    ],
                    'required'=> false
                ])

            ->add('mobile','text',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'mobile'
                    ],
                    'required'=> false
                ])
            ->add('email','email',
                [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'email address'
                    ],
                    'required'=> false
                ])

//            ->add('age','text',
//                [
//                    'attr' => [
//                        'class' => 'form-control',
//                        'placeholder' => 'age'
//                    ],
//                    'required'=> false
//                ])
            ->add('dob', 'date',
                [
                    'required' => FALSE,
                    'label'=> 'Birth Date',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => [
                        'class' => 'form-control',
                        'data-format'=> 'yyyy-MM-dd',
                        'placeholder' => 'date of birth'
                    ]
                ])
            ->add('gender','choice', [
                'attr' => ['class' => 'form-control', 'placeholder'=> 'gender'],
                'choices' => [
                    'MALE' => 'Male',
                    'FEMALE' => 'Female',
                    'OTHERS' => 'Others'
                ]
            ])


            ->add('hasSurgery', 'choice', [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    '0' => 'NO',
                    '1' => 'YES'
                ]
            ])
//            ->add('memberId')
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
                'label' => 'Photo',
                'required' => FALSE,
                'attr' => ['class' => 'form-control']
            ])
            ->add('joinedDate', 'date',
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => ['class' => 'form-control', 'data-format'=> 'yyyy-MM-dd']
                ]
            )
//            ->add('isPremiumMember', 'choice',[
//                'label' => 'Is Premium',
//                'attr' => [ 'class'=>'form-control' ],
//                'choices' => [
//                    '0' => 'NO',
//                    '1' => 'YES'
//                ]
//            ])
            ->add('premiumExpiryDate', 'date',
                [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => 'Premium Expiry Date',
                    'required' => FALSE,
                    'attr' => ['class' => 'form-control', 'data-format'=> 'yyyy-MM-dd']
                ]
            )
            ->add('add', 'submit', [
                'label' => 'SAVE',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
//            ->add('cancel', 'button', [
//                'attr' => [
//                    'class' => 'btn btn-primary'
//                ]
//            ])
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
        return 'familyhealth_memberbundle_member';
    }
}
