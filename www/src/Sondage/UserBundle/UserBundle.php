<?php
/**
 * Created by JetBrains PhpStorm.
 * User: DGIAMPOR
 * Date: 19/03/13
 * Time: 17:29
 * To change this template use File | Settings | File Templates.
 */

namespace Sondage\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

Class UserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }

}