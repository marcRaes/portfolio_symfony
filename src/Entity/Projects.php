<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME', fields: ['name'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_URL', fields: ['url'])]
#[UniqueEntity(fields: ['name'], message: 'Il existe déjà un projet avec ce nom')]
#[UniqueEntity(fields: ['url'], message: 'Il existe déjà un projet avec cette URL')]
#[Vich\Uploadable]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: "projects", fileNameProperty: "picture")]
    private ?File $pictureFile = null;

    #[ORM\Column]
    private ?bool $training = null;

    /**
     * @var Collection<int, Skills>
     */
    #[ORM\ManyToMany(targetEntity: Skills::class, inversedBy: 'projects')]
    #[Assert\Count(min: 1, minMessage: 'Vous devez sélectionner au moins une compétence')]
    private Collection $skills;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?bool $display = null;

    /**
     * @var Collection<int, DevTools>
     */
    #[ORM\ManyToMany(targetEntity: DevTools::class, inversedBy: 'projects')]
    #[Assert\Count(min: 1, minMessage: 'Vous devez sélectionner au moins un outil de développement')]
    private Collection $devTools;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlGit = null;

    private ?string $listSkills = null;

    private ?string $listDevTools = null;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->devTools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?File $pictureFile): static
    {
        $this->pictureFile = $pictureFile;

        if ($pictureFile !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function isTraining(): ?bool
    {
        return $this->training;
    }

    public function setTraining(bool $training): static
    {
        $this->training = $training;

        return $this;
    }

    /**
     * @return Collection<int, Skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isDisplay(): ?bool
    {
        return $this->display;
    }

    public function setDisplay(bool $display): static
    {
        $this->display = $display;

        return $this;
    }

    /**
     * @return Collection<int, DevTools>
     */
    public function getDevTools(): Collection
    {
        return $this->devTools;
    }

    public function addDevTool(DevTools $devTool): static
    {
        if (!$this->devTools->contains($devTool)) {
            $this->devTools->add($devTool);
        }

        return $this;
    }

    public function removeDevTool(DevTools $devTool): static
    {
        $this->devTools->removeElement($devTool);

        return $this;
    }

    public function getUrlGit(): ?string
    {
        return $this->urlGit;
    }

    public function setUrlGit(?string $urlGit): static
    {
        $this->urlGit = $urlGit;

        return $this;
    }

    public function getListSkills(): ?string
    {
        foreach($this->skills as $skill) {
            if(empty($this->listSkills)) {
                $this->listSkills = $skill->getName();
            } else {
                $this->listSkills .= ', ' . $skill->getName();
            }
        }

        return $this->listSkills;
    }

    public function getListDevTools(): ?string
    {
        foreach($this->devTools as $devTools) {
            if(empty($this->listDevTools)) {
                $this->listDevTools = $devTools->getName();
            } else {
                $this->listDevTools .= ', ' . $devTools->getName();
            }
        }

        return $this->listDevTools;
    }
}
