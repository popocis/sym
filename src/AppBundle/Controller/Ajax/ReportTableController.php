<?php

namespace AppBundle\Controller\Ajax;

use AppBundle\Entity\UserEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @Route("/ajax/reportTable")
 */
class ReportTableController extends Controller {
	/**
	 * @Route("/alerts.json", name="ajax_bootstrap-table_alert", methods="GET")
	 */
	public function listAction(Request $request) {
		$sort = $request->get('sort', 'id');
		$order = $request->get('order', 'desc');
		$offset = $request->get('offset', '0');
		$limit = $request->get('limit', '100');
		$from = $request->get('from');
		$to = $request->get('to');
		if($from == null){
			$date = new \DateTime();
			$date->modify('-10 day');
			$from = date_create($date->format('Y-m-d'));
		}
		else{
			$from_explode = explode("/", $from);
			$from = date_create($from_explode[2].'-'.$from_explode[1].'-'.$from_explode[0]);
		}
		if($to == null){
			$date = new \DateTime();
			$to = date_create($date->format('Y-m-d'));
		}
		else{
			$to_explode = explode("/", $to);
			$to = date_create($to_explode[2].'-'.$to_explode[1].'-'.$to_explode[0]);
		}
		$em = $this->getDoctrine()->getManager();
		$events = $this->listEvents($em, $sort, $order, $offset, $limit, $from, $to);
		$eventsCount = $this->countEvents($em, $from, $to);
		return new JsonResponse($this->encodeUsersToJson($events, $eventsCount));
	}

	private function encodeUsersToJson(array $events, $eventsCount) {
		$result = array();
		foreach ($events as $event) {
			$date = $event->getDate();
			if (!is_null($date)) {
				$date = $date->format('d/m/Y');
			}
			$estimate = $event->getEstimate();
			if (!is_null($estimate)) {
				if($estimate == 2999){
					$estimate = "< 3000";
				}
				else if($estimate == 3000){
					$estimate = ">= 3000";
				}
				else if($estimate == 5000){
					$estimate = ">= 5000";
				}
			}
			$formOrigin = $event->getFormOrigin();
			if (!is_null($formOrigin)) {
				$formOrigin = $formOrigin->getFormName().' - '.$formOrigin->getFormDomain();
			}
			$result[] = array(
				'id' => '<span class="">'.$event->getId().'</span>',
				'contactMethod' => '<span class="">'.$event->getContactMethod().'</span>',
				'contactReason' => '<span class="">'.$event->getContactReason().'</span>',
				'date' => '<span class="">'.$date.'</span>',
				'message' => '<span class="">'.$event->getMessage().'</span>',
				'notes' => '<span class="">'.$event->getNotes().'</span>',
				'estimate' => '<span class="">'.$estimate.'</span>',
				'formOrigin' => '<span class="">'.$formOrigin.'</span>',
				'clientId' => '<span class="">'.$event->getCustomerUser()->getId().'</span>',
			);
		}
		return array(
			'total' => $eventsCount,
			'rows' => $result
		);
	}

	private function listEvents($em, $sort, $order, $offset, $limit, $from, $to) {
		$qb = $em->createQueryBuilder();
		$qb->select('e');
		$qb->from('AppBundle:UserEvent', 'e');
		$from_date = new \DateTime($from->format("Y-m-d")." 00:00:00");
		$to_date   = new \DateTime($to->format("Y-m-d")." 23:59:59");
		$qb->andWhere('e.date BETWEEN :from AND :to')
			->setParameter('from', $from_date )
			->setParameter('to', $to_date);

		$qb->setFirstResult($offset);
		$qb->setMaxResults($limit);
		$qb->orderBy('e.'.$sort, $order);
		return $qb->getQuery()->getResult();
	}

	private function countEvents($em, $from, $to) {
		$qb = $em->createQueryBuilder();
		$qb->select('count(e)');
		$qb->from('AppBundle:UserEvent', 'e');
		$from_date = new \DateTime($from->format("Y-m-d")." 00:00:00");
		$to_date   = new \DateTime($to->format("Y-m-d")." 23:59:59");
		$qb->andWhere('e.date BETWEEN :from AND :to')
			->setParameter('from', $from_date )
			->setParameter('to', $to_date);
		return $qb->getQuery()->getSingleScalarResult();
	}
}
