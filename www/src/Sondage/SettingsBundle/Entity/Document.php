<?php
// src/Sondage/SettingsBundle/Entity/Document.php

namespace Sondage\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="files")
 * @ORM\HasLifecycleCallbacks()
 */
class Document
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    private $file;

    private $tempFilename;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->path = $this->file->guessExtension();

            // Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
            $this->alt = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if (null === $this->file) {
            return;
        }

        // Si on avait un ancien fichier, on le supprime
        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move(
            $this->getUploadRootDir(), // Le répertoire de destination
            $this->id.'.'.$this->path   // Le nom du fichier à créer, ici « id.extension »
        );
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->tempFilename) {
            unlink($this->tempFilename);
        }
    }

    /**
     * @return string
     */
    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/documents';
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->path ? null : '/'.$this->getUploadDir().'/'.$this->id.'.'.$this->path;
    }

    /**
     * @return uploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return Document
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        return $this;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    public function getPath()
    {
        return $this->path;
    }
}