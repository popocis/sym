<?php

namespace AppBundle\Controller\Ajax;

use AppBundle\Entity\Alert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @Route("/ajax/alert")
 */
class AlertTableController extends Controller {
	/**
	 * @Route("/confirm/{id}", name="ajaxUserAlertConfirm")
	 */
	public function alertConfirmAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$alert = $doc->getRepository('AppBundle:Alert')->findOneBy(array('id' => $id));
		$date = new \DateTime();
		$alert->setFirstContact($date);
		$alert->setFirstContactAttempts(0);
		$em->persist($alert);
		$em->flush();
		$response = new Response();
		$response->setContent(json_encode([
			'response' => 'alert confirm',
		]));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("/confirmlater/{id}", name="ajaxUserAlertConfirmLater")
	 */
	public function alertConfirmLaterAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$alert = $doc->getRepository('AppBundle:Alert')->findOneBy(array('id' => $id));
		$date = $alert->getRegistrationDate()->format('Y-m-d');
		$date = new \DateTime($date);
		$date = $date->modify('+6 months');
		$alert->setFirstContact($date);
		$alert->setFirstContactAttempts(NULL);
		$em->persist($alert);
		$em->flush();
		$response = new Response();
		$response->setContent(json_encode([
			'response' => '',
		]));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("/notconfirm/{id}", name="ajaxUserAlertNotConfirm")
	 */
	public function alertNotConfirmAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$alert = $doc->getRepository('AppBundle:Alert')->findOneBy(array('id' => $id));
		$firstContactAttempts = $alert->getFirstContactAttempts();
		if($firstContactAttempts == NULL) {
			$date = $alert->getRegistrationDate()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+1 week');
			$alert->setFirstContactAttempts(1);
			$alert->setFirstContact($date);
		}
		else if($firstContactAttempts == 1){
			$date = $alert->getFirstContact()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+2 week');
			$alert->setFirstContactAttempts(2);
			$alert->setFirstContact($date);
		}
		else if($firstContactAttempts == 2) {
			$alert->setFirstContactAttempts(3);
			$user = $alert->getCustomerUser();
			$user->setDeleted(true);
		}
		$em->persist($alert);
		$em->flush();
		$response = new Response();
		$response->setContent(json_encode([
			'response' => '',
		]));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("/confirmappointment/{id}", name="ajaxUserAlertConfirmAppointment")
	 */
	public function alertConfirmAppointmentAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$alert = $doc->getRepository('AppBundle:Alert')->findOneBy(array('id' => $id));
		$date = new \DateTime();
		$alert->setAppointment($date);
		$alert->setAppointmentAttempts(0);
		$em->persist($alert);
		$em->flush();
		$response = new Response();
		$response->setContent(json_encode([
			'response' => 'alert confirm',
		]));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("/notconfirmappointment/{id}", name="ajaxUserAlertNotConfirmAppointment")
	 */
	public function alertNotConfirmAppointmentAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$alert = $doc->getRepository('AppBundle:Alert')->findOneBy(array('id' => $id));
		$appointmentAttempts = $alert->getAppointmentAttempts();
		if($appointmentAttempts == NULL) {
			$date = $alert->getAppointment()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+1 day');
			$alert->setAppointmentAttempts(1);
			$alert->setAppointment($date);
		}
		else if($appointmentAttempts == 1){
			$date = $alert->getAppointment()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+1 day');
			$alert->setAppointmentAttempts(2);
			$alert->setAppointment($date);
		}
		else if($appointmentAttempts == 2) {
			$date = $alert->getAppointment()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+1 day');
			$alert->setAppointmentAttempts(0);
			$alert->setAppointment($date);
		}
		$em->persist($alert);
		$em->flush();
		$response = new Response();
		$response->setContent(json_encode([
			'response' => 'alert confirm',
		]));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("/confirmappointmentafter/{id}", name="ajaxUserAlertConfirmAppointmentAfter")
	 */
	public function alertConfirmAppointmentAfterAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$alert = $doc->getRepository('AppBundle:Alert')->findOneBy(array('id' => $id));
		$date = new \DateTime();
		$alert->setAppointmentAfter($date);
		$alert->setAppointmentAfterAttempts(0);
		$em->persist($alert);
		$em->flush();
		$response = new Response();
		$response->setContent(json_encode([
			'response' => 'alert confirm',
		]));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("/notconfirmappointmentafter/{id}", name="ajaxUserAlertNotConfirmAppointmentAfter")
	 */
	public function alertNotConfirmAppointmentAfterAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$alert = $doc->getRepository('AppBundle:Alert')->findOneBy(array('id' => $id));
		$appointmentAfterAttempts = $alert->getAppointmentAfterAttempts();
		if($appointmentAfterAttempts == NULL) {
			$date = $alert->getAppointmentAfter()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+1 day');
			$alert->setAppointmentAfterAttempts(1);
			$alert->setAppointmentAfter($date);
		}
		else if($appointmentAfterAttempts == 1){
			$date = $alert->getAppointmentAfter()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+1 day');
			$alert->setAppointmentAfterAttempts(2);
			$alert->setAppointmentAfter($date);
		}
		else if($appointmentAfterAttempts == 2) {
			$date = $alert->getAppointmentAfter()->format('Y-m-d');
			$date = new \DateTime($date);
			$date = $date->modify('+1 day');
			$alert->setAppointmentAfterAttempts(0);
			$alert->setAppointmentAfter($date);
		}
		$em->persist($alert);
		$em->flush();
		$response = new Response();
		$response->setContent(json_encode([
			'response' => 'alert confirm',
		]));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

}
