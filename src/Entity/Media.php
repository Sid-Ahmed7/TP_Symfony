<?php

namespace App\Entity;

use App\Enum\MediaTypeEnum;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $short_description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $long_description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(length: 255)]
    private ?string $cover_image = null;

    #[ORM\Column]
    private array $staff = [];

    #[ORM\Column(enumType: MediaTypeEnum::class)]
    private ?MediaTypeEnum $media_type = null;

    /**
     * @var Collection<int, MediaLanguage>
     */
    #[ORM\OneToMany(targetEntity: MediaLanguage::class, mappedBy: 'media')]
    private Collection $mediaLanguages;

    /**
     * @var Collection<int, CategoryMedia>
     */
    #[ORM\OneToMany(targetEntity: CategoryMedia::class, mappedBy: 'media')]
    private Collection $categoryMedia;

    public function __construct()
    {
        $this->mediaLanguages = new ArrayCollection();
        $this->categoryMedia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): static
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->long_description;
    }

    public function setLongDescription(string $long_description): static
    {
        $this->long_description = $long_description;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->cover_image;
    }

    public function setCoverImage(string $cover_image): static
    {
        $this->cover_image = $cover_image;

        return $this;
    }

    public function getStaff(): array
    {
        return $this->staff;
    }

    public function setStaff(array $staff): static
    {
        $this->staff = $staff;

        return $this;
    }

    public function getMediaType(): ?MediaTypeEnum
    {
        return $this->media_type;
    }

    public function setMediaType(MediaTypeEnum $media_type): static
    {
        $this->media_type = $media_type;

        return $this;
    }

    /**
     * @return Collection<int, MediaLanguage>
     */
    public function getMediaLanguages(): Collection
    {
        return $this->mediaLanguages;
    }

    public function addMediaLanguage(MediaLanguage $mediaLanguage): static
    {
        if (!$this->mediaLanguages->contains($mediaLanguage)) {
            $this->mediaLanguages->add($mediaLanguage);
            $mediaLanguage->setMedia($this);
        }

        return $this;
    }

    public function removeMediaLanguage(MediaLanguage $mediaLanguage): static
    {
        if ($this->mediaLanguages->removeElement($mediaLanguage)) {
            // set the owning side to null (unless already changed)
            if ($mediaLanguage->getMedia() === $this) {
                $mediaLanguage->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryMedia>
     */
    public function getCategoryMedia(): Collection
    {
        return $this->categoryMedia;
    }

    public function addCategoryMedium(CategoryMedia $categoryMedium): static
    {
        if (!$this->categoryMedia->contains($categoryMedium)) {
            $this->categoryMedia->add($categoryMedium);
            $categoryMedium->setMedia($this);
        }

        return $this;
    }

    public function removeCategoryMedium(CategoryMedia $categoryMedium): static
    {
        if ($this->categoryMedia->removeElement($categoryMedium)) {
            // set the owning side to null (unless already changed)
            if ($categoryMedium->getMedia() === $this) {
                $categoryMedium->setMedia(null);
            }
        }

        return $this;
    }
}