<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostAttachementRepository")
 */
class PostAttachement
{
    private const UPLOAD_DIR = './uploads/postAttachs';
    private const PUBLIC_UPLOAD_DIR = '/uploads/postAttachs';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $alt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /** @var UploadedFile $file */
    private $file;

    private $name;



    public function __construct()
    {
        $this->path = '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)    
        if (null === $this->file) {
            return;
        }

        $this->file->move(self::UPLOAD_DIR, $this->name);

        // On le met manuellement à null pour des eventuels problèmes de serialization
        $this->file = '';
    }

    static public function rand(): string
    {
        return uniqid(sha1(microtime()), true);
    }

    public function preUpload(?UploadedFile $file)
    {
        $this->file = $file;

        // Si jamais il n'y a pas de fichier (champ facultatif)    
        if (null === $this->file) {
            return;
        }

        $this->name = self::rand() . '.' . $this->file->guessExtension();

        $this->setPath(self::PUBLIC_UPLOAD_DIR . '/' . $this->name);
    }

    public function file()
    {
        return $this->file;
    }
}
