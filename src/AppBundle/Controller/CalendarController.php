<?php

namespace AppBundle\Controller;

use DateTime;
use DateInterval;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

/**
 * @Route("/calendar")
 */
class CalendarController extends Controller {
	/**
	 * @Route(name="calendar")
	 */
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		$model = Yaml::parse($this->get('kernel')->getRootDir() . '/config/calendar.yml');

		return $this->render('calendar/index.html.twig', $model);
	}

	/**
	 * @Route("/feed.json", name="calendarFeed")
	 */
	public function feedAction(Request $request) {
		$type = $request->get('type', null);
		$start = $request->get('start', null);
		$end = $request->get('end', null);

		if (!$type or !$start or !$end) {
			return new JsonResponse(array('error' => true));
		}

		$userJourneyRepo = $this->getDoctrine()->getRepository('AppBundle:UserJourney');

		$criteria = new Criteria();
        $criteria->where(Criteria::expr()->gte($type, new DateTime($start)));
        $criteria->andWhere(Criteria::expr()->lte($type, new DateTime($end)));

		$userJourneys = $userJourneyRepo->matching($criteria);

		return new JsonResponse($this->mapUserJourneys($userJourneys, $type));
	}

	/**
	 * @Route("/customers.json", name="calenderCustomers")
	 */
	public function customersAction(Request $request) {
		$start = $request->get('start', '2016-11-27');
		$end = $request->get('end', '2017-01-08');

		if (!$start or !$end) {
			return new JsonResponse(array('error' => true));
		}

		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		$qb->select('u')
			->from('AppBundle:User', 'u')
			->innerJoin('u.customerJourneys', 'uj')
			->where(
				$qb->expr()->orX(
					$qb->expr()->andX(
						$qb->expr()->gte('uj.arrivalDate', ':start'),
						$qb->expr()->lte('uj.arrivalDate', ':end')
					),
					$qb->expr()->andX(
						$qb->expr()->gte('uj.appointmentDate', ':start'),
						$qb->expr()->lte('uj.appointmentDate', ':end')
					),
                    $qb->expr()->andX(
                        $qb->expr()->gte('uj.appointmentTwoDate', ':start'),
                        $qb->expr()->lte('uj.appointmentTwoDate', ':end')
                    ),
                    $qb->expr()->andX(
                        $qb->expr()->gte('uj.appointmentThreeDate', ':start'),
                        $qb->expr()->lte('uj.appointmentThreeDate', ':end')
                    ),
					$qb->expr()->andX(
						$qb->expr()->gte('uj.departureDate', ':start'),
						$qb->expr()->lte('uj.departureDate', ':end')
					)
				)
			)
			->orderBy('u.name')
			->setParameter('start', new DateTime($start), \Doctrine\DBAL\Types\Type::DATETIME)
			->setParameter('end', new DateTime($end), \Doctrine\DBAL\Types\Type::DATETIME);

		$results = $qb->distinct()->getQuery()->getResult();

		// mapping

		$json = array();
		foreach ($results as $q) {
			$json[] = array(
				'id' => $q->getId(),
				'name' => $q->getName() . ' ' . $q->getSurname(),
				'url' => $this->generateUrl('userView', array('id' => $q->getId()))
			);
		}

		return new JsonResponse($json);
	}

	private function mapUserJourneys($userJourneys, $type) {
		$result = array();

		foreach ($userJourneys as $uj) {
			$customer = $uj->getCustomerUser();
			$userName = $customer->getName() . ' ' . $customer->getSurname();
			$title = $userName;
			$date = null;
			// $end = null;

			switch ($type) {
				case 'arrivalDate':
					$date = $uj->getArrivalDate();
					$title = 'Arrivo ' . $title;
					break;
				case 'appointmentDate':
					$date = $uj->getAppointmentDate();
					$title = 'Primo appuntamento ' . $title;
					break;
                case 'appointmentTwoDate':
                    $date = $uj->getAppointmentTwoDate();
                    $title = 'Secondo appuntamento ' . $title;
                    break;
                case 'appointmentThreeDate':
                    $date = $uj->getAppointmentThreeDate();
                    $title = 'Terzo appuntamento ' . $title;
                    break;
				case 'departureDate':
					$date = $uj->getDepartureDate();
					$title = 'Partenza ' . $title;
					break;
			}

			$model = array(
				'id' => $type . $uj->getId(),
				'type' => $type,
				'title' => $title,
				'allDay' => $type != 'appointmentDate' && $type != 'appointmentTwoDate' && $type != 'appointmentThreeDate',
				'start' => $date->format(DateTime::ATOM),
				'userName' => $userName,
				'userUrl' => $this->generateUrl('userView', array('id' => $uj->getCustomerUser()->getId())),
				'notes' => $uj->getNotes()
			);

			if ($type == 'appointmentDate' || $type == 'appointmentTwoDate' || $type == 'appointmentThreeDate') {
				$model['clinicId'] = $uj->getClinic()->getId();
				$model['clinicName'] = $uj->getClinic()->getName();
			} else {
				$model['accommodation'] = $uj->getAccommodation();
				$model['accommodationAddress'] = $uj->getAccommodationAddress();
				$model['nightLoadToClient'] = $uj->getNightLoadClient();
				$model['nightLoadToHC'] = $uj->getNightLoadHc();
				$model['transportLoadToClient'] = $uj->getTransportLoadClient();
				$model['transportLoadToHC'] = $uj->getTransportLoadHc();
			}

			$result[] = $model;
		}

		return $result;
	}
}
