<?php

namespace FamilyHealth\InstitutionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',[
                'label' => 'Name Of Institution',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('phone','text',[
                'label' => 'Phone',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email','email',[
                'label' => 'Email',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
//            ->add('createdDate')
            ->add('address','textarea',[
                'label' => 'Address',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
//            ->add('status')
            ->add('add','submit',[
                'attr'=> ['class' => 'btn btn-primary']
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FamilyHealth\InstitutionBundle\Entity\Institution'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'familyhealth_institutionbundle_institution';
    }
}
