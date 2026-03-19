<?php

namespace App\Entity;

use App\Repository\CountryProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryProductRepository::class)]
#[ORM\Table(name: '`proj_country_product`')]
class CountryProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $id_product = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $id_country = null;

    #[ORM\Column]
    private ?int $stock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduct(): ?Product
    {
        return $this->id_product;
    }

    public function setIdProduct(?Product $id_product): static
    {
        $this->id_product = $id_product;

        return $this;
    }

    public function getIdCountry(): ?Country
    {
        return $this->id_country;
    }

    public function setIdCountry(?Country $id_country): static
    {
        $this->id_country = $id_country;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }
}
