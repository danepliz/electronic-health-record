<?php

namespace FamilyHealth\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FamilyHealthUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
