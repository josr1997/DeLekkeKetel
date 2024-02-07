<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id = 0;

    #[ORM\Column(length: 255)]
    private ?string $videoId;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $thumbnailName = null;

    #[ORM\Column(type: "integer")]
    private ?int $duration = 0;

    #[ORM\Column(type: "datetime")]
    private \DateTime $uploadDateTime;

    public function getId(): int
    {
        return $this->id;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): void
    {
        $this->videoId = $videoId;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getThumbnailName(): ?string
    {
        return $this->thumbnailName;
    }

    public function setThumbnailName(string $thumbnailName): static
    {
        $this->thumbnailName = $thumbnailName;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): void
    {
        $this->duration = $duration;
    }

    public function getUploadDateTime(): \DateTime
    {
        return $this->uploadDateTime;
    }

    public function setUploadDateTime(\DateTime $uploadDateTime): void
    {
        $this->uploadDateTime = $uploadDateTime;
    }

}
