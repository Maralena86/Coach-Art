<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

      /**
     * @Vich\UploadableField(mapping="events_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Basket $basket = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\ManyToMany(targetEntity: ArtEvent::class, mappedBy: 'users')]
    private Collection $artEvents;

    #[Timestampable(on:'create')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[Timestampable(on:'update')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    

    public function __construct()
    {
        $this->setBasket(new Basket());
        $this->orders = new ArrayCollection();
        $this->artEvents = new ArrayCollection();
        $this->propositions = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(Basket $basket): self
    {
        // set the owning side of the relation if necessary
        if ($basket->getUser() !== $this) {
            $basket->setUser($this);
        }

        $this->basket = $basket;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ArtEvent>
     */
    public function getArtEvents(): Collection
    {
        return $this->artEvents;
    }

    public function addArtEvent(ArtEvent $artEvent): self
    {
        if (!$this->artEvents->contains($artEvent)) {
            $this->artEvents->add($artEvent);
            $artEvent->addUser($this);
        }

        return $this;
    }

    public function removeArtEvent(ArtEvent $artEvent): self
    {
        if ($this->artEvents->removeElement($artEvent)) {
            $artEvent->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Proposition>
     */
    public function getPropositions(): Collection
    {
        return $this->propositions;
    }

   
       
    public function setImageFile(File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        
        if ($imageFile) {
           
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

}
