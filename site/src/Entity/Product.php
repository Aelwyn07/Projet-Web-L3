<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Entity\CountryProduct;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: '`proj_product`')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $unit_price = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CountryProduct::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $countryProducts;

    public function __construct()
    {
        $this->countryProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(float $unit_price)
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock)
    {
        $this->stock = $stock;

        return $this;
    }

    // Retourne la liste des pays dans lesquels on retrouve le produit
    public function getCountryProducts(): Collection
    {
        return $this->countryProducts;
    }

    // Ajouter le produit à un nouveau pays -> table intermédiaire
    public function addCountryProduct(CountryProduct $cp)
    {
        if (!$this->countryProducts->contains($cp)) {
            $this->countryProducts->add($cp);
            $cp->setProduct($this);
        }
        return $this;
    }

    // Retirer le produit d'un pays
    public function removeCountryProduct(CountryProduct $cp)
    {
        if ($this->countryProducts->removeElement($cp)) {
            $cp->setProduct(null);
        }
        return $this;
    }
}
