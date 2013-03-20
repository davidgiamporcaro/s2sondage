<?php
/**
 * Created by JetBrains PhpStorm.
 * User: DGIAMPOR
 * Date: 19/03/13
 * Time: 17:33
 * To change this template use File | Settings | File Templates.
 */

// src/Sondage/UserBundle/Entity/User.php

namespace Sondage\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sondage_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}