<?php
// src/Sondage/SettingsBundle/Entity/Settings.php

namespace Sondage\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="settings")
 * @ORM\HasLifecycleCallbacks()
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    public function __construct()
    {
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Settings
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

}