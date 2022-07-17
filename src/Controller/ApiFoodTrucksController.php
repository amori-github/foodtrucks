<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\TruckDriver;
use App\Repository\BookingRepository;
use App\Repository\TruckDriverRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;

class ApiFoodTrucksController extends AbstractController
{

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws ORMException
     * @throws Exception
     */
    #[Route('/ApiFoodTrucks/post', name: 'food_trucks', methods: 'POST')]
    public function postApi(Request $request, BookingRepository $bookingRepo, TruckDriverRepository $truckDriverRepo): JsonResponse
    {
        $truckDriver = new TruckDriver();
        $booking = new Booking();
        $parameter = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $dateOfDay = new \DateTime();

        $email = $parameter['email'];
        $dateConveted = implode("-", array_reverse(explode("/", $parameter['date'])));
        $bookingDate = new \DateTime($dateConveted);
        $bookingDateStart = new \DateTime($dateConveted);
        $bookingDateLast = new \DateTime($dateConveted);

        $numberOfReservations = $bookingRepo->searchBookingByDate($bookingDate);
        $nbOfGaragesByDay = ($bookingDate->format('l') == 'Friday') ? 6 : 7;

        $startDayOfWeek = $bookingDateStart->modify('Monday this week');
        $lastDayOfWeek  = $bookingDateLast->modify('Sunday this week');

        $nbBookingByWeekForTruckDriver = $bookingRepo->searchBookingInTheWeek($startDayOfWeek,$lastDayOfWeek, $email);

        if ($bookingDate <= $dateOfDay){
            return $this->json(printf("Vous ne pouvez pas réserver le même jour ni à une date antérieure."));
        }

        if ($numberOfReservations >= $nbOfGaragesByDay){
            return $this->json(printf("Toutes les places sont réservées."));
        }

        if ($nbBookingByWeekForTruckDriver !== 0){
            return $this->json(printf("Il est possible de réserver juste une fois par semaine."));
        }

        $truckDriverExists = $truckDriverRepo->findOneBy(array('email' => $email));
        if (!$truckDriverExists){
            $truckDriver->setName($parameter['name']);
            $truckDriver->setFirstName($parameter['firstName']);
            $truckDriver->setEmail($email);
            $booking->setTruckDriver($truckDriver);
            $em->persist($truckDriver);
        } else {
            $booking->setTruckDriver($truckDriverExists);
            $em->persist($truckDriverExists);
        }

        $booking->setDate($bookingDate);
        $em->persist($booking);
        $em->flush();

        return $this->json(printf("Votre réservation est prise."));
    }

}
