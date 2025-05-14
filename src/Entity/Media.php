<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Media
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'media_file', fileNameProperty: 'mediaName', size: 'mediaSize')]
    private ?File $mediaFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $mediaName = null;

    #[ORM\Column(nullable: true)]
    private ?int $mediaSize = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setMediaFile(?File $mediaFile = null): static
    {
        $this->mediaFile = $mediaFile;

        if (null !== $mediaFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getMediaFile(): ?File
    {
        return $this->mediaFile;
    }

    public function setMediaName(?string $mediaName): void
    {
        $this->mediaName = $mediaName;
    }

    public function getMediaName(): ?string
    {
        return $this->mediaName;
    }

    public function setMediaSize(?int $mediaSize): void
    {
        $this->mediaSize = $mediaSize;
    }

    public function getMediaSize(): ?int
    {
        return $this->mediaSize;
    }
}
