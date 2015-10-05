<?php

namespace FamilyHealth\InstitutionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstitutionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('phone')
            ->add('email')
            ->add('createdDate')
            ->add('address')
            ->add('status')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
