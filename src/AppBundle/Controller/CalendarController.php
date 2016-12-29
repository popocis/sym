<?php

namespace AppBundle\Controller;

use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Collections\Criteria;

/**
 * @Route("/calendar")
 */
class CalendarController extends Controller {
	/**
	 * @Route(name="calendar")
	 */
	public function indexAction() {
		// $userJourneyRepo = $this->getDoctrine()->getRepository('AppBundle:UserJourney');
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		$model = Yaml::parse($this->get('kernel')->getRootDir() . '/config/calendar.yml');

		// foreach ($model['calendars'] as $c) {
		// 	$criteria = new Criteria();
		// 	$criteria->where(Criteria::expr()->gte('arrivalDate', new DateTime($start)));
		// 	$criteria->andWhere(Criteria::expr()->lte('arrivalDate', new DateTime($end)));

		// 	$qb = $em->createQueryBuilder();

		// 	$qb->select('count(u)');
		// 	$qb->from('AppBundle:User', 'u');
		// 	$qb->where(QueryBuilder::expr()->andX(
		// 		QueryBuilder::expr()->gte($c->dateName, new DateTime($start)),
		// 		QueryBuilder::expr()->gte($c->dateName, new DateTime($start))
		// 	));

		// 	return $qb->getQuery()->getSingleScalarResult();
			
		// 	$userJourneys = $userJourneyRepo->matching($criteria);
		// }

		return $this->render('calendar/index.html.twig', $model);
	}

	/**
	 * @Route("/feed.json", name="feed")
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

	private function mapUserJourneys($userJourneys, $type) {
		$result = array();

		foreach ($userJourneys as $uj) {
			$customer = $uj->getCustomerUser();
			$date = null;

			switch ($type) {
				case 'arrivalDate':
					$date = $uj->getArrivalDate();
					break;
				case 'appointmentDate':
					$date = $uj->getAppointmentDate();
					break;
				case 'departureDate':
					$date = $uj->getDepartureDate();
					break;
			}

			$result[] = array(
				'id' => $uj->getId(),
				'title' => $customer->getName() . ' ' . $customer->getSurname(),
				'allDay' => false,
				'start' => $date->format(DateTime::ATOM)
			);
		}

		return $result;
	}
}
