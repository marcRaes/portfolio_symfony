<?php

namespace App\Entity;

use App\Interface\ImageHolderInterface;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cette email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, ImageHolderInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(type: "phone_number", length: 15, nullable: true)]
    #[AssertPhoneNumber(type: [AssertPhoneNumber::MOBILE], defaultRegion: 'FR')]
    private ?PhoneNumber $phone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 10, max: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $job = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $catchPhrase = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\Length(min: 6, minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.')]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    /**
     * @var Collection<int, Skills>
     */
    #[ORM\OneToMany(targetEntity: Skills::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $skills;

    /**
     * @var Collection<int, Projects>
     */
    #[ORM\OneToMany(targetEntity: Projects::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $projects;

    /**
     * @var Collection<int, Quotes>
     */
    #[ORM\OneToMany(targetEntity: Quotes::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $quotes;

    /**
     * @var Collection<int, DevTools>
     */
    #[ORM\OneToMany(targetEntity: DevTools::class, mappedBy: 'user')]
    private Collection $devTools;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->quotes = new ArrayCollection();
        $this->devTools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
         $this->plainPassword = null;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function setPhone(?PhoneNumber $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstName' => $this->firstName,
            'email' => $this->email,
            'phone' => $this->phone,
            'dateOfBirth' => $this->dateOfBirth,
            'address' => $this->address,
            'password' => $this->password,
            'photo' => $this->picture,
        ];
    }

    public function __unserialize(array $serialized): void
    {
        $this->id = $serialized['id'];
        $this->name = $serialized['name'];
        $this->firstName = $serialized['firstName'];
        $this->email = $serialized['email'];
        $this->phone = $serialized['phone'];
        $this->dateOfBirth = $serialized['dateOfBirth'];
        $this->address = $serialized['address'];
        $this->password = $serialized['password'];
        $this->picture = $serialized['photo'];
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
            $skill->setUser($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getUser() === $this) {
                $skill->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Projects>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Projects $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setUser($this);
        }

        return $this;
    }

    public function removeProject(Projects $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getUser() === $this) {
                $project->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quotes>
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quotes $quote): static
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes->add($quote);
            $quote->setUser($this);
        }

        return $this;
    }

    public function removeQuote(Quotes $quote): static
    {
        if ($this->quotes->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getUser() === $this) {
                $quote->setUser(null);
            }
        }

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getCatchPhrase(): ?string
    {
        return $this->catchPhrase;
    }

    public function setCatchPhrase(?string $catchPhrase): static
    {
        $this->catchPhrase = $catchPhrase;

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
            $devTool->setUser($this);
        }

        return $this;
    }

    public function removeDevTool(DevTools $devTool): static
    {
        if ($this->devTools->removeElement($devTool)) {
            // set the owning side to null (unless already changed)
            if ($devTool->getUser() === $this) {
                $devTool->setUser(null);
            }
        }

        return $this;
    }
}
