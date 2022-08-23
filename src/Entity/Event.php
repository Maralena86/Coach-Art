<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\EnumVisibilityType;
use App\Repository\EventRepository;
use App\DoctrineType\MessageTypeEnum;
use App\DoctrineType\OptionTypeEnum;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    const OPTIONS_PRESENTIAL = "presential";
    const OPTIONS_REMOTE = "remote";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 255)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column]
    private $price;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[Timestampable(on:'create')]
    #[ORM\Column(type: 'datetime')]
    private  $createdAt ;

    #[Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime')]
    private  $updatedAt ;

    #[ORM\Column(length: 255)]
    private  $image;

   
    /**
     * @Vich\UploadableField(mapping="events_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

 

    #[ORM\Column(length: 255)]
    private ?string $options = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Article::class)]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    








    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }



    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setEvent($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getEvent() === $this) {
                $article->setEvent(null);
            }
        }

        return $this;
    }
    

    
}
