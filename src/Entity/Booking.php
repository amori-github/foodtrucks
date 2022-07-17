<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use DateTime;
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


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTruckDriver()
    {
        return $this->truckDriver;
    }

    /**
     * @param mixed $truckDriver
     */
    public function setTruckDriver($truckDriver): void
    {
        $this->truckDriver = $truckDriver;
    }

    /**
     * @return
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

}
