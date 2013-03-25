<?php

namespace Sondage\AuthenticatedUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SondageAuthenticatedUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}