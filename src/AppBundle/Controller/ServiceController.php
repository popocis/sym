<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DemOrigin;
use AppBundle\Entity\FormOrigin;
use AppBundle\Entity\Clinic;
use AppBundle\Entity\Presentation;
use AppBundle\Entity\Treatment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\FormOriginType;
use AppBundle\Form\ClinicType;
use AppBundle\Form\DemOriginType;
use AppBundle\Form\PresentationType;
use AppBundle\Form\TreatmentType;

class ServiceController extends Controller {
	/**
	 * @Route("/service/add", name="serviceAdd")
	 */
	public function serviceAddAction(Request $request){

		$formOriginId = isset($request->request->get('form_origin')['id']) ? $request->request->get('form_origin')['id'] : null;
		if (!is_null($formOriginId)){
			$formOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->find($formOriginId);
		} else {
			$formOrigin = new FormOrigin();
		}
		$formFormOrigin = $this->createForm(FormOriginType::class, $formOrigin);

		$clinicId = isset($request->request->get('clinic')['id']) ? $request->request->get('clinic')['id'] : null;
		if (!is_null($clinicId)){
			$clinic = $this->getDoctrine()->getRepository('AppBundle:Clinic')->find($clinicId);
		} else {
			$clinic = new Clinic();
		}
		$formClinic = $this->createForm(ClinicType::class, $clinic);

		$demOriginId = isset($request->request->get('dem_origin')['id']) ? $request->request->get('dem_origin')['id'] : null;
		if (!is_null($demOriginId)){
			$demOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->find($demOriginId);
		} else {
			$demOrigin = new DemOrigin();
		}
		$formDemOrigin = $this->createForm(DemOriginType::class, $demOrigin);

		$presentationId = isset($request->request->get('presentation')['id']) ? $request->request->get('presentation')['id'] : null;
		if (!is_null($presentationId)){
			$presentation = $this->getDoctrine()->getRepository('AppBundle:Presentation')->find($presentationId);
		} else {
			$presentation = new Presentation();
		}
		$formPresentation = $this->createForm(PresentationType::class, $presentation);

		$treatmentId = isset($request->request->get('treatment')['id']) ? $request->request->get('treatment')['id'] : null;
		if (!is_null($treatmentId)){
			$treatment = $this->getDoctrine()->getRepository('AppBundle:Treatment')->find($treatmentId);
		} else {
			$treatment = new Treatment();
		}
		$formTreatment = $this->createForm(TreatmentType::class, $treatment);


		if('POST' === $request->getMethod()) {
			if($request->request->has('form_origin')){
				$formFormOrigin->handleRequest($request);
				if ($formFormOrigin->isSubmitted() && $formFormOrigin->isValid()) {
					$formOrigin = $formFormOrigin->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($formOrigin);
					$em->flush();
				}
			}
			elseif($request->request->has('clinic')) {
				$formClinic->handleRequest($request);
				if ($formClinic->isSubmitted() && $formClinic->isValid()) {
					$clinic = $formClinic->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($clinic);
					$em->flush();
				}
			}
			elseif($request->request->has('dem_origin')) {
				$formDemOrigin->handleRequest($request);
				if ($formDemOrigin->isSubmitted() && $formDemOrigin->isValid()) {
					$demOrigin = $formDemOrigin->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($demOrigin);
					$em->flush();
				}
			}
			elseif($request->request->has('presentation')) {
				$formPresentation->handleRequest($request);
				if ($formPresentation->isSubmitted() && $formPresentation->isValid()) {
					$presentation = $formPresentation->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($presentation);
					$em->flush();
				}
			}
			elseif($request->request->has('treatment')) {
				$formTreatment->handleRequest($request);
				if ($formTreatment->isSubmitted() && $formTreatment->isValid()) {
					$treatment = $formTreatment->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($treatment);
					$em->flush();
				}
			}
		}

		$formsOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->findAll();
		$demsOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->findAll();
		$clinics = $this->getDoctrine()->getRepository('AppBundle:Clinic')->findAll();
		$presentations = $this->getDoctrine()->getRepository('AppBundle:Presentation')->findAll();
		$treatments = $this->getDoctrine()->getRepository('AppBundle:Treatment')->findAll();

		return $this->render('service/add.html.twig', array( 'clinics' => $clinics, 'presentations' => $presentations, 'formsOrigin' => $formsOrigin, 'demsOrigin' => $demsOrigin, 'treatments' => $treatments,'formFormOrigin' => $formFormOrigin->createView(), 'formClinic' => $formClinic->createView(), 'formDemOrigin' => $formDemOrigin->createView(), 'formPresentation' => $formPresentation->createView(), 'formTreatment' => $formTreatment->createView() ));
	}

	/**
	 * @Route("/service/formorigin/edit/{id}", name="ajax_formFormOriginEdit")
	 */
	public function editFormOriginAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$formOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->find($id);
			$formFormOrigin = $this->createForm(FormOriginType::class, $formOrigin);
			return $this->container->get('templating')->renderResponse('service/formFormOriginEdit.html.twig', array('formFormOrigin' => $formFormOrigin->createView(), 'formOrigin' => $formOrigin ));
		}
	}

	/**
	 * @Route("/service/clinic/edit/{id}", name="ajax_formClinicEdit")
	 */
	public function editClinicAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$clinic = $this->getDoctrine()->getRepository('AppBundle:Clinic')->find($id);
			$formClinic = $this->createForm(ClinicType::class, $clinic);
			return $this->container->get('templating')->renderResponse('service/formClinicEdit.html.twig', array('formClinic' => $formClinic->createView(), 'clinic' => $clinic ));
		}
	}

	/**
	 * @Route("/service/demorigin/edit/{id}", name="ajax_formDemOriginEdit")
	 */
	public function editDemOriginAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$demOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->find($id);
			$formDemOrigin = $this->createForm(DemOriginType::class, $demOrigin);
			return $this->container->get('templating')->renderResponse('service/formDemOriginEdit.html.twig', array('formDemOrigin' => $formDemOrigin->createView(), 'demOrigin' => $demOrigin ));
		}
	}

	/**
	 * @Route("/service/presentation/edit/{id}", name="ajax_formPresentationEdit")
	 */
	public function editPresentationAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$presentation = $this->getDoctrine()->getRepository('AppBundle:Presentation')->find($id);
			$formPresentation = $this->createForm(PresentationType::class, $presentation);
			return $this->container->get('templating')->renderResponse('service/formPresentationEdit.html.twig', array('formPresentation' => $formPresentation->createView(), 'presentation' => $presentation ));
		}
	}

	/**
	 * @Route("/service/treatment/edit/{id}", name="ajax_formTreatmentEdit")
	 */
	public function editTreatmentAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$treatment = $this->getDoctrine()->getRepository('AppBundle:Treatment')->find($id);
			$formTreatment = $this->createForm(TreatmentType::class, $treatment);
			return $this->container->get('templating')->renderResponse('service/formTreatmentEdit.html.twig', array('formTreatment' => $formTreatment->createView(), 'treatment' => $treatment ));
		}
	}

	/**
	 * @Route("/service/report", name="serviceReport")
	 */
	public function servicereportAction(){

		$em = $this->getDoctrine()->getManager();

		$qb = $em->createQueryBuilder('a');
		$qb->select('count(a.id)');
		$qb->from('AppBundle:User', 'a');
		$qb->andWhere('a.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('a.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('a.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersAllSource = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersAllSource = 0;
		}

		$qb = $em->createQueryBuilder('b');
		$qb->select('count(b.id)');
		$qb->from('AppBundle:Quote', 'b');
		try {
			$quotesSent = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$quotesSent = 0;
		}

		$qb = $em->createQueryBuilder('c');
		$qb->select('count(c.id)');
		$qb->from('AppBundle:User', 'c');
		$qb->where('c.status LIKE :status')
			->setParameter('status', 'interested%');
		$qb->andWhere('c.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('c.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('c.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersInterested = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersInterested = 0;
		}

		$qb = $em->createQueryBuilder('d');
		$qb->select('count(d.id)');
		$qb->from('AppBundle:UserJourney', 'd');
		$qb->groupBy('d.customerUser');
		try {
			$usersAppointment = $qb->getQuery()->getScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersAppointment = 0;
		}

		$qb = $em->createQueryBuilder('e');
		$qb->select('count(e.id)');
		$qb->from('AppBundle:UserEvent', 'e');
		$qb->where('e.contactReason LIKE :contactReason')
			->setParameter('contactReason', 'interestedLater%');
		try {
			$usersInterestedLater = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersInterestedLater = 0;
		}

		/*$qb->select('e');
		$qb->from('AppBundle:Alert', 'e');
		$qb->where('e.eventAttempts IS NULL OR e.eventAttempts != 0')
			->andWhere('e.eventDate <= :today')
			->setParameter('today', new \DateTime());
		$qb->orderBy('e.eventDate', 'ASC');
		$alertsEvents = $qb->getQuery()->getResult();

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
		$alertsAppointmentAfter = $qb->getQuery()->getResult();*/
		
		return $this->render('service/report.html.twig', array('usersAllSource'=>$usersAllSource, 'quotesSent'=>$quotesSent, 'usersInterested'=>$usersInterested, 'usersAppointment'=>$usersAppointment, 'usersInterestedLater'=>$usersInterestedLater));
	}

	/**
	 * @Route("/service/report/overview/{startDate}/{endDate}", name="ajax_report_overview")
	 */
	public function overviewAction($startDate,$endDate){
		if ($this->container->get('request')->isXmlHttpRequest()) {

			$data = array();

			if($startDate == "null" || $endDate == "null"){
				$data['validDates'] = false;
			}
			else{
				$startDate = date('Y-m-d', strtotime($startDate));
				$endDate = date('Y-m-d', strtotime($endDate));
				if(self::validateDate($startDate) && self::validateDate($endDate)) {
					$data['validDates'] = true;
				}
			}

			if($data['validDates'] == true){
				$data['query'] = true;

				$startDate = new \DateTime($startDate);
				$startDate = $startDate->modify('-1 day');
				$endDate = new \DateTime($endDate);
				$endDate = $endDate->modify('+1 day');

				$em = $this->getDoctrine()->getManager();

				$qb = $em->createQueryBuilder('a');
				$qb->select('count(a.id)');
				$qb->from('AppBundle:User', 'a');
				$qb->where('a.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				$qb->andWhere('a.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('a.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('a.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersAllSource = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersAllSource = 0;
				}

				$data['usersAllSource'] = $usersAllSource;

				$qb = $em->createQueryBuilder('b');
				$qb->select('count(b.id)');
				$qb->from('AppBundle:Quote', 'b');
				$qb->andWhere('b.date BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$quotesSent = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$quotesSent = 0;
				}

				$data['quotesSent'] = $quotesSent;

				$qb = $em->createQueryBuilder('c');
				$qb->select('count(c.id)');
				$qb->from('AppBundle:User', 'c');
				$qb->where('c.status LIKE :status')
					->setParameter('status', 'interested%');
				$qb->andWhere('c.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				$qb->andWhere('c.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('c.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('c.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersInterested = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersInterested = 0;
				}

				$data['usersInterested'] = $usersInterested;

				$qb = $em->createQueryBuilder('d');
				$qb->select('count(d.id)');
				$qb->from('AppBundle:UserJourney', 'd');
				$qb->andWhere('d.appointmentDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				$qb->groupBy('d.customerUser');
				try {
					$usersAppointment = $qb->getQuery()->getScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersAppointment = 0;
				}

				$data['usersAppointment'] = $usersAppointment;

				$qb = $em->createQueryBuilder('e');
				$qb->select('count(e.id)');
				$qb->from('AppBundle:UserEvent', 'e');
				$qb->where('e.contactReason LIKE :contactReason')
					->setParameter('contactReason', 'interestedLater%');
				$qb->andWhere('e.date BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersInterestedLater = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersInterestedLater = 0;
				}

				$data['usersInterestedLater'] = $usersInterestedLater;

			}
			else{
				$data['query'] = true;

				$em = $this->getDoctrine()->getManager();

				$qb = $em->createQueryBuilder('a');
				$qb->select('count(a.id)');
				$qb->from('AppBundle:User', 'a');
				$qb->where('a.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('a.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('a.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersAllSource = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersAllSource = 0;
				}

				$data['usersAllSource'] = $usersAllSource;

				$qb = $em->createQueryBuilder('b');
				$qb->select('count(b.id)');
				$qb->from('AppBundle:Quote', 'b');
				try {
					$quotesSent = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$quotesSent = 0;
				}

				$data['quotesSent'] = $quotesSent;

				$qb = $em->createQueryBuilder('c');
				$qb->select('count(c.id)');
				$qb->from('AppBundle:User', 'c');
				$qb->where('c.status LIKE :status')
					->setParameter('status', 'interested%');
				$qb->andWhere('c.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('c.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('c.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersInterested = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersInterested = 0;
				}

				$data['usersInterested'] = $usersInterested;

				$qb = $em->createQueryBuilder('d');
				$qb->select('count(d.id)');
				$qb->from('AppBundle:UserJourney', 'd');
				$qb->groupBy('d.customerUser');
				try {
					$usersAppointment = $qb->getQuery()->getScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersAppointment = 0;
				}

				$data['usersAppointment'] = $usersAppointment;

				$qb = $em->createQueryBuilder('e');
				$qb->select('count(e.id)');
				$qb->from('AppBundle:UserEvent', 'e');
				$qb->where('e.contactReason LIKE :contactReason')
					->setParameter('contactReason', 'interestedLater%');
				try {
					$usersInterestedLater = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersInterestedLater = 0;
				}

				$data['usersInterestedLater'] = $usersInterestedLater;
			}

			$data['startDate'] = $startDate;
			$data['endDate'] = $endDate;

			$response = new JsonResponse(json_encode($data));
			return $response;
		}
	}

	public function validateDate($date, $format = 'Y-m-d'){
		$d = \DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

}

