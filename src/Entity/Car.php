<?php

namespace App\Entity;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;






#[ORM\Entity(repositoryClass: Car::class)]
#[Vich\Uploadable]
class Car
{

    const TYPE=[
        'voiture'=>'voiture',
        'moto'=>'moto'

    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[Vich\UploadableField(mapping:"car_image", fileNameProperty:"filename")]
    private  $imageFile;

    #[ORM\Column]
    private string|null $filename;

    #[ORM\Column]
    #[Assert\Range(min:2, max:6)]
    private ?int $nbSeats = null;

    #[ORM\Column]
    #[Assert\Range(min:2, max:4)]
    private ?int $nbDoors = null;

    #[ORM\Column]
    private ?bool $disponible = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTime $created_at = null;
    #[ORM\Column]
    private ?\DateTime $update_at = null;

    #[ORM\Column]
    private ?float $costs = null;

    #[ORM\ManyToOne(inversedBy: 'name')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarCategory $carCategory = null;

  

   

  

    public function __construct()
    {
        $this->created_at=new DateTime();
        $this->update_at=new DateTime();
        $this->carCategories = new ArrayCollection();
       
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }


    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->name);
    }

   


    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

  

    /**
     * Get the value of update_at
     */ 
    public function getUpdate_at()
    {
        return $this->update_at;
    }

    /**
     * Set the value of update_at
     *
     * @return  self
     */ 
    public function setUpdate_at($update_at)
    {
        $this->update_at = $update_at;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of nbDoors
     */ 
    public function getNbDoors()
    {
        return $this->nbDoors;
    }

    /**
     * Set the value of nbDoors
     *
     * @return  self
     */ 
    public function setNbDoors($nbDoors)
    {
        $this->nbDoors = $nbDoors;

        return $this;
    }

    /**
     * Get the value of costs
     */ 
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * Set the value of costs
     *
     * @return  self
     */ 
    public function setCosts($costs)
    {
        $this->costs = $costs;

        return $this;
    }

    /**
     * Get the value of nbSeats
     */ 
    public function getNbSeats()
    {
        return $this->nbSeats;
    }

    /**
     * Set the value of nbSeats
     *
     * @return  self
     */ 
    public function setNbSeats($nbSeats)
    {
        $this->nbSeats = $nbSeats;

        return $this;
    }

    /**
     * @return Collection<int, CarCategory>
     */
    public function getCarCategories(): Collection
    {
        return $this->carCategories;
    }

    public function getCarCategory(): ?CarCategory
    {
        return $this->carCategory;
    }

    public function setCarCategory(?CarCategory $carCategory): self
    {
        $this->carCategory = $carCategory;

        return $this;
    }

   


    /**
     * Get the value of imageFile
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @return  self
     */ 
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile){
            $this->updated_at = new  \DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of filename
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
