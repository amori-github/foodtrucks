<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TruckDriver")
     */
    private $truckDriver;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->truckDriver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, TruckDriver>
     */
    public function getTruckDriver(): Collection
    {
        return $this->truckDriver;
    }

    public function addTruckDriver(TruckDriver $truckDriver): self
    {
        if (!$this->truckDriver->contains($truckDriver)) {
            $this->truckDriver[] = $truckDriver;
        }

        return $this;
    }

    public function removeTruckDriver(TruckDriver $truckDriver): self
    {
        $this->truckDriver->removeElement($truckDriver);

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
}
