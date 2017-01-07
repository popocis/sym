<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AlertController extends Controller {
	/**
	 * @Route("/alert", name="alert")
	 */
	public function indexAction(){
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		$qb->select('e');
		$qb->from('AppBundle:Alert', 'e');
		$qb->where('e.firstContactAttempts IS NULL OR e.firstContactAttempts != 0')
		   ->andWhere('e.firstContact <= :today')
		   ->setParameter('today', new \DateTime());
		$qb->orderBy('e.firstContact', 'ASC');
		$alertsNewUser = $qb->getQuery()->getResult();

		$qb->select('a');
		$qb->from('AppBundle:Alert', 'a');
		$qb->where('a.appointmentAttempts IS NULL OR a.appointmentAttempts != 0')
			->andWhere('a.appointment <= :today')
			->setParameter('today', new \DateTime());
		$qb->orderBy('a.appointment', 'ASC');
		$alertsAppointment = $qb->getQuery()->getResult();

		$qb->select('p');
		$qb->from('AppBundle:Alert', 'p');
		$qb->where('p.appointmentAfterAttempts IS NULL OR p.appointmentAfterAttempts != 0')
			->andWhere('p.appointmentAfter <= :today')
			->setParameter('today', new \DateTime());
		$qb->orderBy('p.appointmentAfter', 'ASC');
		$alertsAppointmentAfter = $qb->getQuery()->getResult();

		return $this->render('alert/index.html.twig', array('alertsNewUser' => $alertsNewUser, 'alertsAppointment' => $alertsAppointment, 'alertsAppointmentAfter' => $alertsAppointmentAfter));
	}
}
