<?php

namespace FamilyHealth\MainBundle\Twig\Extension;



class TemplateRenderExtension extends \Twig_Extension{


    public function getFunctions(){
        return [
            'form_input_wrapper' => new \Twig_Function_Function('formInputWrapper')
        ];

    }

    public function formInputWrapper(){
        return 'Testing input wrapper';
    }

    public function getName(){
        return 'template_render_extension';
    }
}