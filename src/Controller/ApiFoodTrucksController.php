<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\TruckDriver;
use App\Repository\BookingRepository;
use DateTime;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiFoodTrucksController extends AbstractController
{

    /**
     * @throws \Exception
     */
    #[Route('/ApiFoodTrucks', name: 'food_trucks', methods: 'POST')]
    public function post_api(Request $request, BookingRepository $bookingRepo): JsonResponse
    {
        $driver = new TruckDriver();
        $booking = new Booking();
        $parameter = json_decode($request->getContent(), true);
        $responseReturned = "Réservation effectué";
        $dateOfDay = new \DateTime();

        $bookingDate = new \DateTime(implode("-", array_reverse(explode("/", $parameter['date']))));
        $numberOfReservations = $bookingRepo->findByNumberOfReservations($bookingDate);
        $nbTruck = ($bookingDate->format('l') == 'Friday') ? 6 : 7;

        $firstDayOfWeek = $bookingDate->modify('Monday this week');
        $lastDayOfWeek = $bookingDate->modify('Sunday this week');

        if ($numberOfReservations < $nbTruck && $bookingDate > $dateOfDay){
            $driver->setName($parameter['name']);
            $driver->setFirstName($parameter['firstName']);
            $booking->addTruckDriver($driver);
            $booking->setDate($bookingDate);

            $em = $this->getDoctrine()->getManager();
            $em->persist($driver);
            $em->persist($booking);
            $em->flush();
        } else {
            $responseReturned = "Emplacements non disponible";
        }

        return $this->json(printf($responseReturned));
    }

}
