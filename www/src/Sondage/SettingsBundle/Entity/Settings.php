<?php
// src/Sondage/SettingsBundle/Entity/Settings.php

namespace Sondage\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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

    /**
     * @ORM\ManyToOne(targetEntity="Sondage\SettingsBundle\Entity\Document", cascade={"persist"})
     */
    private $documents;

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


    /**
     * @param Sondage\SettingsBundle\Entity\Document $document
     * @return Settings
     */
    public function setDocuments(\Sondage\SettingsBundle\Entity\Document $document = null)
    {
        $this->documents = $document;
        return $this;
    }


    /**
     * @return Sondage\SettingsBundle\Entity\Document
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}