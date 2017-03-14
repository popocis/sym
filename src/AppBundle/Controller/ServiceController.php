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

		$qb = $em->createQueryBuilder('f');
		$qb->select('count(f.id)');
		$qb->from('AppBundle:User', 'f');
		$qb->where('f.source LIKE :source')
			->setParameter('source', 'website%');
		$qb->andWhere('f.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('f.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('f.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersFromWebsite = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersFromWebsite = 0;
		}

		$qb = $em->createQueryBuilder('g');
		$qb->select('count(g.id)');
		$qb->from('AppBundle:User', 'g');
		$qb->where('g.source LIKE :source')
			->setParameter('source', 'dem%');
		$qb->andWhere('g.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('g.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('g.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersFromDem = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersFromDem = 0;
		}

		$qb = $em->createQueryBuilder('h');
		$qb->select('count(h.id)');
		$qb->from('AppBundle:User', 'h');
		$qb->where('h.source LIKE :source')
			->setParameter('source', 'facebook%');
		$qb->andWhere('h.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('h.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('h.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersFromFacebook = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersFromFacebook = 0;
		}

		$qb = $em->createQueryBuilder('i');
		$qb->select('count(i.id)');
		$qb->from('AppBundle:User', 'i');
		$qb->where('i.source LIKE :source')
			->setParameter('source', 'agent%');
		try {
			$usersFromAgent = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersFromAgent = 0;
		}

		$qb = $em->createQueryBuilder('l');
		$qb->select('count(l.id)');
		$qb->from('AppBundle:User', 'l');
		$qb->where('l.source LIKE :source OR l.source LIKE :source2')
			->setParameter('source', 'wordofmouth%')
			->setParameter('source2', 'transit%');
		$qb->andWhere('l.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('l.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('l.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersFromWordofmouth = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersFromWordofmouth = 0;
		}

		$qb = $em->createQueryBuilder('m');
		$qb->select('count(m.id)');
		$qb->from('AppBundle:User', 'm');
		$qb->where('m.source LIKE :source OR m.source LIKE :source2')
			->setParameter('source', 'presentation%')
			->setParameter('source2', 'events%');
		$qb->andWhere('m.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('m.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('m.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersFromPresentation = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersFromPresentation = 0;
		}

		$qb = $em->createQueryBuilder('n');
		$qb->select('count(n.id)');
		$qb->from('AppBundle:User', 'n');
		$qb->where('n.source LIKE :source OR n.source LIKE :source2')
			->setParameter('source', 'other%')
			->setParameter('source2', 'phone%');
		$qb->andWhere('n.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('n.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('n.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersFromOther = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersFromOther = 0;
		}

		$users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

		$firstContactPhone = 0;
		$firstContactEmail = 0;
		$firstContactViber = 0;
		$firstContactWhatsapp = 0;
		$firstContactFacebook = 0;
		$firstContactFacetime = 0;
		$firstContactFacetoface = 0;
		$firstContactForm = 0;
		$firstContactOther = 0;

		foreach($users as $user) {

			$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $user), array('date' => 'ASC'));

			if(count($events)>0){
				if($events[0]->getContactMethod() == "phone"){
					$firstContactPhone++;
				}
				else if($events[0]->getContactMethod() == "email"){
					$firstContactEmail++;
				}
				else if($events[0]->getContactMethod() == "viber"){
					$firstContactViber++;
				}
				else if($events[0]->getContactMethod() == "whatsapp"){
					$firstContactWhatsapp++;
				}
				else if($events[0]->getContactMethod() == "facebook"){
					$firstContactFacebook++;
				}
				else if($events[0]->getContactMethod() == "facetime"){
					$firstContactFacetime++;
				}
				else if($events[0]->getContactMethod() == "facetoface"){
					$firstContactFacetoface++;
				}
				else if($events[0]->getContactMethod() == "form"){
					$firstContactForm++;
				}
				else if($events[0]->getContactMethod() == "other"){
					$firstContactOther++;
				}
			}
		}

		$qb = $em->createQueryBuilder('p');
		$qb->select('count(p.id)');
		$qb->from('AppBundle:User', 'p');
		$qb->where('p.status LIKE :status')
			->setParameter('status', 'client%');
		$qb->andWhere('p.roles NOT LIKE :roles_super_admin')
			->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
		$qb->andWhere('p.roles NOT LIKE :roles_admin')
			->setParameter('roles_admin', '%"ROLE_ADMIN"%');
		$qb->andWhere('p.roles NOT LIKE :roles_agent')
			->setParameter('roles_agent', '%"ROLE_AGENT"%');
		try {
			$usersClient = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$usersClient = 0;
		}

		$qb = $em->createQueryBuilder('q');
		$qb->select('count(q.id)');
		$qb->from('AppBundle:UserEvent', 'q');
		try {
			$messages = $qb->getQuery()->getSingleScalarResult();
		}
		catch (\Doctrine\ORM\NoResultException $e) {
			$messages = 0;
		}

		return $this->render('service/report.html.twig', array(
			'usersAllSource'=>$usersAllSource,
			'quotesSent'=>$quotesSent,
			'usersInterested'=>$usersInterested,
			'usersAppointment'=>$usersAppointment,
			'usersInterestedLater'=>$usersInterestedLater,
			'usersFromWebsite'=>$usersFromWebsite,
			'usersFromDem'=>$usersFromDem,
			'usersFromFacebook'=>$usersFromFacebook,
			'usersFromAgent'=>$usersFromAgent,
			'usersFromWordofmouth'=>$usersFromWordofmouth,
			'usersFromPresentation'=>$usersFromPresentation,
			'usersFromOther'=>$usersFromOther,
			'firstContactPhone'=>$firstContactPhone,
			'firstContactEmail'=>$firstContactEmail,
			'firstContactViber'=>$firstContactViber,
			'firstContactWhatsapp'=>$firstContactWhatsapp,
			'firstContactFacebook'=>$firstContactFacebook,
			'firstContactFacetime'=>$firstContactFacetime,
			'firstContactFacetoface'=>$firstContactFacetoface,
			'firstContactForm'=>$firstContactForm,
			'firstContactOther'=>$firstContactOther,
			'usersClient'=>$usersClient,
			'messages'=>$messages
			));
	}

	/**
	 * @Route("/service/report/overview/{startDate}/{endDate}/{websiteViews}", name="ajax_report_overview")
	 */
	public function overviewAction($startDate,$endDate,$websiteViews){
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

			if($websiteViews == "null"){
				$websiteViews = 0;
			}

			$data['websiteViews'] = $websiteViews;

			if($data['validDates'] == true){
				$data['query'] = true;

				$startDate = new \DateTime($startDate);
				//$startDate = $startDate->modify('-1 day');
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
				$qb->where('b.date BETWEEN :startDate AND :endDate')
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
				$qb->where('d.appointmentDate BETWEEN :startDate AND :endDate')
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

				$qb = $em->createQueryBuilder('f');
				$qb->select('count(f.id)');
				$qb->from('AppBundle:User', 'f');
				$qb->where('f.source LIKE :source')
					->setParameter('source', 'website%');
				$qb->andWhere('f.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('f.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('f.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('f.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersFromWebsite = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromWebsite = 0;
				}

				$data['usersFromWebsite'] = $usersFromWebsite;

				$qb = $em->createQueryBuilder('g');
				$qb->select('count(g.id)');
				$qb->from('AppBundle:User', 'g');
				$qb->where('g.source LIKE :source')
					->setParameter('source', 'dem%');
				$qb->andWhere('g.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('g.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('g.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('g.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersFromDem = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromDem = 0;
				}

				$data['usersFromDem'] = $usersFromDem;

				$qb = $em->createQueryBuilder('h');
				$qb->select('count(h.id)');
				$qb->from('AppBundle:User', 'h');
				$qb->where('h.source LIKE :source')
					->setParameter('source', 'facebook%');
				$qb->andWhere('h.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('h.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('h.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('h.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersFromFacebook = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromFacebook = 0;
				}

				$data['usersFromFacebook'] = $usersFromFacebook;

				$qb = $em->createQueryBuilder('i');
				$qb->select('count(i.id)');
				$qb->from('AppBundle:User', 'i');
				$qb->where('i.source LIKE :source')
					->setParameter('source', 'agent%');
				$qb->andWhere('i.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('i.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('i.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('i.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersFromAgent = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromAgent = 0;
				}

				$data['usersFromAgent'] = $usersFromAgent;

				$qb = $em->createQueryBuilder('l');
				$qb->select('count(l.id)');
				$qb->from('AppBundle:User', 'l');
				$qb->where('l.source LIKE :source OR l.source LIKE :source2')
					->setParameter('source', 'wordofmouth%')
					->setParameter('source2', 'transit%');
				$qb->andWhere('l.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('l.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('l.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('l.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersFromWordofmouth = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromWordofmouth = 0;
				}

				$data['usersFromWordofmouth'] = $usersFromWordofmouth;

				$qb = $em->createQueryBuilder('m');
				$qb->select('count(m.id)');
				$qb->from('AppBundle:User', 'm');
				$qb->where('m.source LIKE :source OR m.source LIKE :source2')
					->setParameter('source', 'presentation%')
					->setParameter('source2', 'events%');
				$qb->andWhere('m.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('m.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('m.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('m.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersFromPresentation = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromPresentation = 0;
				}

				$data['usersFromPresentation'] = $usersFromPresentation;

				$qb = $em->createQueryBuilder('n');
				$qb->select('count(n.id)');
				$qb->from('AppBundle:User', 'n');
				$qb->where('n.source LIKE :source OR n.source LIKE :source2')
					->setParameter('source', 'other%')
					->setParameter('source2', 'phone%');
				$qb->andWhere('n.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('n.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('n.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('n.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersFromOther = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromOther = 0;
				}

				$data['usersFromOther'] = $usersFromOther;


				$qb = $em->createQueryBuilder('o');
				$qb->select('o.id');
				$qb->from('AppBundle:User', 'o');
				$qb->where('o.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('o.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('o.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('o.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);

				$users = $qb->getQuery()->getResult();

				$firstContactPhone = 0;
				$firstContactEmail = 0;
				$firstContactViber = 0;
				$firstContactWhatsapp = 0;
				$firstContactFacebook = 0;
				$firstContactFacetime = 0;
				$firstContactFacetoface = 0;
				$firstContactForm = 0;
				$firstContactOther = 0;

				foreach($users as $user) {

					$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $user["id"]), array('date' => 'ASC'));

					if(count($events)>0){
						if($events[0]->getContactMethod() == "phone"){
							$firstContactPhone++;
						}
						else if($events[0]->getContactMethod() == "email"){
							$firstContactEmail++;
						}
						else if($events[0]->getContactMethod() == "viber"){
							$firstContactViber++;
						}
						else if($events[0]->getContactMethod() == "whatsapp"){
							$firstContactWhatsapp++;
						}
						else if($events[0]->getContactMethod() == "facebook"){
							$firstContactFacebook++;
						}
						else if($events[0]->getContactMethod() == "facetime"){
							$firstContactFacetime++;
						}
						else if($events[0]->getContactMethod() == "facetoface"){
							$firstContactFacetoface++;
						}
						else if($events[0]->getContactMethod() == "form"){
							$firstContactForm++;
						}
						else if($events[0]->getContactMethod() == "other"){
							$firstContactOther++;
						}
					}
				}

				$data['firstContactPhone']=$firstContactPhone;
				$data['firstContactEmail']=$firstContactEmail;
				$data['firstContactViber']=$firstContactViber;
				$data['firstContactWhatsapp']=$firstContactWhatsapp;
				$data['firstContactFacebook']=$firstContactFacebook;
				$data['firstContactFacetime']=$firstContactFacetime;
				$data['firstContactFacetoface']=$firstContactFacetoface;
				$data['firstContactForm']=$firstContactForm;
				$data['firstContactOther']=$firstContactOther;

				$qb = $em->createQueryBuilder('p');
				$qb->select('count(p.id)');
				$qb->from('AppBundle:User', 'p');
				$qb->where('p.status LIKE :status')
					->setParameter('status', 'client%');
				$qb->andWhere('p.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('p.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('p.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				$qb->andWhere('p.registrationDate BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$usersClient = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersClient = 0;
				}

				$data['usersClient']=$usersClient;

				$qb = $em->createQueryBuilder('q');
				$qb->select('count(q.id)');
				$qb->from('AppBundle:UserEvent', 'q');
				$qb->where('q.date BETWEEN :startDate AND :endDate')
					->setParameter('startDate', $startDate)
					->setParameter('endDate', $endDate);
				try {
					$messages = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$messages = 0;
				}

				$data['messages']=$messages;

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

				$qb = $em->createQueryBuilder('f');
				$qb->select('count(f.id)');
				$qb->from('AppBundle:User', 'f');
				$qb->where('f.source LIKE :source')
					->setParameter('source', 'website%');
				$qb->andWhere('f.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('f.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('f.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersFromWebsite = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromWebsite = 0;
				}

				$data['usersFromWebsite'] = $usersFromWebsite;

				$qb = $em->createQueryBuilder('g');
				$qb->select('count(g.id)');
				$qb->from('AppBundle:User', 'g');
				$qb->where('g.source LIKE :source')
					->setParameter('source', 'dem%');
				$qb->andWhere('g.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('g.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('g.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersFromDem = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromDem = 0;
				}

				$data['usersFromDem'] = $usersFromDem;

				$qb = $em->createQueryBuilder('h');
				$qb->select('count(h.id)');
				$qb->from('AppBundle:User', 'h');
				$qb->where('h.source LIKE :source')
					->setParameter('source', 'facebook%');
				$qb->andWhere('h.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('h.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('h.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersFromFacebook = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromFacebook = 0;
				}

				$data['usersFromFacebook'] = $usersFromFacebook;

				$qb = $em->createQueryBuilder('i');
				$qb->select('count(i.id)');
				$qb->from('AppBundle:User', 'i');
				$qb->where('i.source LIKE :source')
					->setParameter('source', 'agent%');
				$qb->andWhere('i.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('i.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('i.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersFromAgent = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromAgent = 0;
				}

				$data['usersFromAgent'] = $usersFromAgent;

				$qb = $em->createQueryBuilder('l');
				$qb->select('count(l.id)');
				$qb->from('AppBundle:User', 'l');
				$qb->where('l.source LIKE :source OR l.source LIKE :source2')
					->setParameter('source', 'wordofmouth%')
					->setParameter('source2', 'transit%');
				$qb->andWhere('l.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('l.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('l.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersFromWordofmouth = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromWordofmouth = 0;
				}

				$data['usersFromWordofmouth'] = $usersFromWordofmouth;

				$qb = $em->createQueryBuilder('m');
				$qb->select('count(m.id)');
				$qb->from('AppBundle:User', 'm');
				$qb->where('m.source LIKE :source OR m.source LIKE :source2')
					->setParameter('source', 'presentation%')
					->setParameter('source2', 'events%');
				$qb->andWhere('m.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('m.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('m.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersFromPresentation = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromPresentation = 0;
				}

				$data['usersFromPresentation'] = $usersFromPresentation;

				$qb = $em->createQueryBuilder('n');
				$qb->select('count(n.id)');
				$qb->from('AppBundle:User', 'n');
				$qb->where('n.source LIKE :source OR n.source LIKE :source2')
					->setParameter('source', 'other%')
					->setParameter('source2', 'phone%');
				$qb->andWhere('n.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('n.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('n.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersFromOther = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersFromOther = 0;
				}

				$data['usersFromOther'] = $usersFromOther;

				$users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

				$firstContactPhone = 0;
				$firstContactEmail = 0;
				$firstContactViber = 0;
				$firstContactWhatsapp = 0;
				$firstContactFacebook = 0;
				$firstContactFacetime = 0;
				$firstContactFacetoface = 0;
				$firstContactForm = 0;
				$firstContactOther = 0;

				foreach($users as $user) {

					$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $user), array('date' => 'ASC'));

					if(count($events)>0){
						if($events[0]->getContactMethod() == "phone"){
							$firstContactPhone++;
						}
						else if($events[0]->getContactMethod() == "email"){
							$firstContactEmail++;
						}
						else if($events[0]->getContactMethod() == "viber"){
							$firstContactViber++;
						}
						else if($events[0]->getContactMethod() == "whatsapp"){
							$firstContactWhatsapp++;
						}
						else if($events[0]->getContactMethod() == "facebook"){
							$firstContactFacebook++;
						}
						else if($events[0]->getContactMethod() == "facetime"){
							$firstContactFacetime++;
						}
						else if($events[0]->getContactMethod() == "facetoface"){
							$firstContactFacetoface++;
						}
						else if($events[0]->getContactMethod() == "form"){
							$firstContactForm++;
						}
						else if($events[0]->getContactMethod() == "other"){
							$firstContactOther++;
						}
					}
				}

				$data['firstContactPhone']=$firstContactPhone;
				$data['firstContactEmail']=$firstContactEmail;
				$data['firstContactViber']=$firstContactViber;
				$data['firstContactWhatsapp']=$firstContactWhatsapp;
				$data['firstContactFacebook']=$firstContactFacebook;
				$data['firstContactFacetime']=$firstContactFacetime;
				$data['firstContactFacetoface']=$firstContactFacetoface;
				$data['firstContactForm']=$firstContactForm;
				$data['firstContactOther']=$firstContactOther;

				$qb = $em->createQueryBuilder('p');
				$qb->select('count(p.id)');
				$qb->from('AppBundle:User', 'p');
				$qb->where('p.status LIKE :status')
					->setParameter('status', 'client%');
				$qb->andWhere('p.roles NOT LIKE :roles_super_admin')
					->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');
				$qb->andWhere('p.roles NOT LIKE :roles_admin')
					->setParameter('roles_admin', '%"ROLE_ADMIN"%');
				$qb->andWhere('p.roles NOT LIKE :roles_agent')
					->setParameter('roles_agent', '%"ROLE_AGENT"%');
				try {
					$usersClient = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$usersClient = 0;
				}

				$data['usersClient']=$usersClient;

				$qb = $em->createQueryBuilder('q');
				$qb->select('count(q.id)');
				$qb->from('AppBundle:UserEvent', 'q');
				try {
					$messages = $qb->getQuery()->getSingleScalarResult();
				}
				catch (\Doctrine\ORM\NoResultException $e) {
					$messages = 0;
				}

				$data['messages']=$messages;

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

