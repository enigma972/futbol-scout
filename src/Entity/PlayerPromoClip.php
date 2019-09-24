<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerPromoClipRepository")
 */
class PlayerPromoClip
{
    private const UPLOAD_DIR = './uploads/player/promo_clips';
    private const PUBLIC_UPLOAD_DIR = '/uploads/player/promo_clips';

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

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $size;


    private $file;

    private $name;


    public function __construct()
    {
        $this->alt = 'Vidéo de promotion';
        $this->path = self::PUBLIC_UPLOAD_DIR.'/f5f277a4a3b13d050078c0b2ee8986f678fc1ed25d866c29c9cd79.94659715.mp4';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function upload()  {    
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

    public function preUpload($file)
    {
        $this->file = $file;

        // Si jamais il n'y a pas de fichier (champ facultatif)    
        if (null === $this->file) {
              return;    
        }

        $this->name = self::rand().'.'.$this->file->guessExtension();
        $this->size = $this->file->getSize()/1000000;
        $this->setPath(self::PUBLIC_UPLOAD_DIR.'/'.$this->name);
    }

    public function file()
    {
        return $this->file;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }
}
