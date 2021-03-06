<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEvent;
use AppBundle\Entity\UserDocument;
use AppBundle\Entity\UserJourney;
use AppBundle\Entity\FormOrigin;
use AppBundle\Entity\Alert;
use AppBundle\Entity\Treatment;
use AppBundle\Entity\Quote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\UserType;
use AppBundle\Form\UserEventType;
use AppBundle\Form\UserDocumentType;
use AppBundle\Form\UserJourneyType;
use AppBundle\Form\QuoteType;

class UserController extends Controller {

	/**
	 * @Route("/user/view/{id}", name="userView")
	 */
	public function viewAction(Request $request, $id) {

		$user = $this->getUserObj($id);
		$formUser = $this->createForm(UserType::class, $user);

		$eventId = isset($request->request->get('user_event')['id']) ? $request->request->get('user_event')['id'] : null;
		if (!is_null($eventId)){
			$userEvent = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->find($eventId);
		} else {
			$userEvent = new UserEvent();
		}
		$formEvent = $this->createForm(UserEventType::class, $userEvent);

		$userDocument = new UserDocument();
		$formDocument = $this->createForm(UserDocumentType::class, $userDocument);

		$journeyId = isset($request->request->get('user_journey')['id']) ? $request->request->get('user_journey')['id'] : null;
		if (!is_null($journeyId)){
			$userJourney = $this->getDoctrine()->getRepository('AppBundle:UserJourney')->find($journeyId);
		} else {
			$userJourney = new UserJourney();
		}
		$formJourney = $this->createForm(UserJourneyType::class, $userJourney);

		$quoteId = isset($request->request->get('quote')['id']) ? $request->request->get('quote')['id'] : null;
		if (!is_null($quoteId)){
			$quote = $this->getDoctrine()->getRepository('AppBundle:Quote')->find($quoteId);
		} else {
			$quote = new Quote();
		}
		$formQuote = $this->createForm(QuoteType::class, $quote);

		if('POST' === $request->getMethod()) {
			if($request->request->has('user_event')){
				$formEvent->handleRequest($request);
				if ($formEvent->isSubmitted() && $formEvent->isValid()) {
					$userEvent = $formEvent->getData();
					$userOperator = $this->get('security.token_storage')->getToken()->getUser();
					$userEvent->setAdminUser($userOperator);
					$userEvent->setCustomerUser($user);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userEvent);
					$em->flush();

					if($userEvent->getContactReason() == "panorex"){
						$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
						if ($alertExist) {
							$userAlert = $alertExist;
							$userAlert->setEstimateSendDate($userEvent->getDate());
							$userAlert->setEstimateRecallDate(null);
							$userAlert->setEstimateRecallAttempts(null);
							$userAlert->setInterestedLaterDate(null);
							$userAlert->setInterestedLaterAttempts(null);
							$userAlert->setCustomerUser($user);
							$em->persist($alertExist);
							$em->flush();
						}
						else{
							$userAlert = new Alert();
							$userAlert->setEstimateSendDate($userEvent->getDate());
							$userAlert->setCustomerUser($user);
							$em->persist($userAlert);
							$em->flush();
						}
					}
					else if($userEvent->getContactReason() == "estimate"){
						$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
						if ($alertExist) {
							$userAlert = $alertExist;
							$userAlert->setEstimateSendDate(null);

							$date = $userEvent->getDate()->format('Y-m-d');
							$estimateRecallDate = new \DateTime($date);
							$estimateRecallDate = $estimateRecallDate->modify('+1 week');
							$userAlert->setEstimateRecallDate($estimateRecallDate);
							$userAlert->setEstimateRecallAttempts(null);

							$userAlert->setCustomerUser($user);
							$em->persist($alertExist);
							$em->flush();
						}
					}
					else if($userEvent->getContactReason() == "recallestimate"){
						$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
						if ($alertExist) {
							$userAlert = $alertExist;

							$attempts = $userAlert->getEstimateRecallAttempts();

							if($attempts == null){
								$date = $userEvent->getDate()->format('Y-m-d');
								$estimateRecallDate = new \DateTime($date);
								$estimateRecallDate = $estimateRecallDate->modify('+2 weeks');
								$userAlert->setEstimateRecallDate($estimateRecallDate);
								$userAlert->setEstimateRecallAttempts(1);
								$userAlert->setCustomerUser($user);
								$em->persist($alertExist);
								$em->flush();
							}
							else if($attempts == 1){
								$userAlert->setEstimateRecallDate(null);
								$userAlert->setEstimateRecallAttempts(null);
								$userAlert->setCustomerUser($user);
								$em->persist($alertExist);
								$em->flush();
							}

						}
					}
					else if($userEvent->getContactReason() == 'acceptedestimate'){
						$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
						if ($alertExist) {
							$userAlert = $alertExist;
							$userAlert->setEstimateRecallDate(null);
							$userAlert->setEstimateRecallAttempts(null);
							$userAlert->setCustomerUser($user);
							$em->persist($alertExist);
							$em->flush();
						}
					}
					else if($userEvent->getContactReason() == "interestedlater"){
						$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
						if ($alertExist) {
							$userAlert = $alertExist;
							$date = $userEvent->getDate()->format('Y-m-d');
							$interestedLaterDate = new \DateTime($date);
							$interestedLaterDate = $interestedLaterDate->modify('+6 months');
							$userAlert->setInterestedLaterDate($interestedLaterDate);
							$userAlert->setInterestedLaterAttempts(null);
							$userAlert->setCustomerUser($user);
							$em->persist($alertExist);
							$em->flush();
						}
						else{
							$userAlert = new Alert();
							$date = $userEvent->getDate()->format('Y-m-d');
							$interestedLaterDate = new \DateTime($date);
							$interestedLaterDate = $interestedLaterDate->modify('+6 months');
							$userAlert->setInterestedLaterDate($interestedLaterDate);
							$userAlert->setInterestedLaterAttempts(null);
							$userAlert->setCustomerUser($user);
							$em->persist($userAlert);
							$em->flush();
						}
					}
					else if($userEvent->getContactReason() == "recallinterestedlater"){
						$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
						if ($alertExist) {
							$userAlert = $alertExist;
							$attempts = $userAlert->getInterestedLaterAttempts();
							if($attempts == null) {
								$date = $userEvent->getDate()->format('Y-m-d');
								$interestedLaterDate = new \DateTime($date);
								$interestedLaterDate = $interestedLaterDate->modify('+1 week');
								$userAlert->setInterestedLaterDate($interestedLaterDate);
								$userAlert->setInterestedLaterAttempts(1);
								$userAlert->setCustomerUser($user);
								$em->persist($alertExist);
								$em->flush();
							}
							else if($attempts == 1){
								$userAlert->setInterestedLaterDate(null);
								$userAlert->setInterestedLaterAttempts(null);
								$userAlert->setCustomerUser($user);
								$em->persist($alertExist);
								$em->flush();
							}
						}
					}
					else if($userEvent->getContactReason() == "recallposttherapy"){
						$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
						if ($alertExist) {
							$userAlert = $alertExist;
							$attempts = $userAlert->getPostTherapyRecallAttempts();
							if($attempts == null) {
								$date = $userEvent->getDate()->format('Y-m-d');
								$postTherapyRecallDate = new \DateTime($date);
								$postTherapyRecallDate = $postTherapyRecallDate->modify('+1 week');
								$userAlert->setPostTherapyRecallDate($postTherapyRecallDate);
								$userAlert->setPostTherapyRecallAttempts(1);
								$userAlert->setCustomerUser($user);
								$em->persist($alertExist);
								$em->flush();
							}
							else if($attempts == 1){
								$userAlert->setPostTherapyRecallDate(null);
								$userAlert->setPostTherapyRecallAttempts(null);
								$userAlert->setCustomerUser($user);
								$em->persist($alertExist);
								$em->flush();
							}
						}
					}
				}
			}
			elseif($request->request->has('user_document')) {
				$formDocument->handleRequest($request);
				if ($formDocument->isSubmitted() && $formDocument->isValid()) {
					$userDocument = $formDocument->getData();
					$userOperator = $this->get('security.token_storage')->getToken()->getUser();
					$userDocument->setAdminUser($userOperator);
					$userDocument->setCustomerUser($user);
					$date = new \DateTime();
					$userDocument->setUploadAt($date);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userDocument);
					$em->flush();
				}
			}
			elseif($request->request->has('user_journey')) {
				$formJourney->handleRequest($request);
				if ($formJourney->isSubmitted() && $formJourney->isValid()) {
					$userJourney = $formJourney->getData();
					if(!is_null($userJourney->getTransportLoadClient())){
						$userJourney->setTransportLoadClient(implode(",",$userJourney->getTransportLoadClient()));
					}
					if(!is_null($userJourney->getTransportLoadHc())){
						$userJourney->setTransportLoadHc(implode(",",$userJourney->getTransportLoadHc()));
					}
					$userOperator = $this->get('security.token_storage')->getToken()->getUser();
					$userJourney->setAdminUser($userOperator);
					$userJourney->setCustomerUser($user);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userJourney);
					$em->flush();

					$alertExist = $this->getDoctrine()->getRepository('AppBundle:Alert')->findOneBy(array('customerUser' => $user));
					$arrivalDate = $userJourney->getArrivalDate()->format('Y-m-d');
					$postTherapyRecallDate = new \DateTime($arrivalDate);
					$postTherapyRecallDate = $postTherapyRecallDate->modify('+3 weeks');

					if ($alertExist) {
						$userAlert = $alertExist;
						$userAlert->setPostTherapyRecallDate($postTherapyRecallDate);
						$userAlert->setPostTherapyRecallAttempts(NULL);
						$userAlert->setCustomerUser($user);
						$em->persist($alertExist);
						$em->flush();
					}

					$em->clear();
				}
			}
			elseif($request->request->has('user')) {
				$formUser->handleRequest($request);
				if ($formUser->isSubmitted() && $formUser->isValid()) {
					$user = $formUser->getData();
					$userManager = $this->get('fos_user.user_manager');
					$user->setUsername($user->getEmail());
					$userManager->updateUser($user, true);
				}
			}
			elseif($request->request->has('quote')) {

				$formQuote->handleRequest($request);
				if ($formQuote->isSubmitted()) {
					$quote = $formQuote->getData();
					$userOperator = $this->get('security.token_storage')->getToken()->getUser();
					$quote->setAdminUser($userOperator);
					$quote->setCustomerUser($user);

					$endDate = $quote->getDate();
					$startDate = new \DateTime('first day of January'.$endDate->format("Y"));

					$em = $this->getDoctrine()->getManager();
					$qb = $em->createQueryBuilder('q');
					$qb->select('count(q.id)');
					$qb->from('AppBundle:Quote', 'q');
					$qb->where('q.date BETWEEN :startDate AND :endDate')
						->setParameter('startDate', $startDate)
						->setParameter('endDate', $endDate);
					try {
						$quoteNr = $qb->getQuery()->getSingleScalarResult();
					}
					catch (\Doctrine\ORM\NoResultException $e) {
						$quoteNr = 1;
					}

					$quote->setQuoteNr($quoteNr+1);

					$em = $this->getDoctrine()->getManager();
					$em->persist($quote);
					$em->flush();
				}
			}
		}

		$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $id), array('date' => 'DESC', 'contactOrigin' => 'DESC'));
		$documents = $this->getDoctrine()->getRepository('AppBundle:UserDocument')->findBy(array('customerUser' => $id));
		$journeys = $this->getDoctrine()->getRepository('AppBundle:UserJourney')->findBy(array('customerUser' => $id));
		$agents = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array('status' => "agent"));
		$formsOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->findAll();
		$demsOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->findAll();
		$clinics = $this->getDoctrine()->getRepository('AppBundle:Clinic')->findAll();
		$presentations = $this->getDoctrine()->getRepository('AppBundle:Presentation')->findAll();
		$treatments = $this->getDoctrine()->getRepository('AppBundle:Treatment')->findAll();
		$quotes = $this->getDoctrine()->getRepository('AppBundle:Quote')->findBy(array('customerUser' => $id));

		return $this->render('user/view.html.twig', array('user' => $user, 'agents' => $agents, 'formsOrigin' => $formsOrigin, 'demsOrigin' => $demsOrigin, 'userEvents' => $events, 'clinics' => $clinics, 'presentations' => $presentations, 'treatments' => $treatments, 'quotes' => $quotes, 'formEvent' => $formEvent->createView(), 'userDocuments' => $documents, 'formDocument' => $formDocument->createView(), 'userJourneys' => $journeys, 'formJourney' => $formJourney->createView(), 'formUser' => $formUser->createView(), 'formQuote' => $formQuote->createView() ));
	}

	private function getUserObj($id) {
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));
		if (!$user) {
			throw $this->createNotFoundException('User not found');
		}
		return $user;
	}

	private function getFormOriginObjByName($formOriginName) {
		//$repository = $this->getDoctrine()->getRepository('AppBundle:FormOrigin');
		//$formOrigin = $repository->findBy(array('formName' => $formOriginName));

		$formOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->findBy(array('formName' => $formOriginName));
		if (!$formOrigin) {
			return null;
		}
		return $formOrigin;
	}

	private function getUserObjByEmail($email) {
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserByEmail($email);
		if (!$user) {
			return null;
		}
		return $user;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => $this->class
		));
	}

	/**
	 * @Route("/download/{userid}/{filename}", name="download_file")
	 */
	public function downloadFileAction($filename, $userid){
		$basePath = $this->container->getParameter('kernel.root_dir').'/user_documents';
		$filePath = $basePath.'/'.$userid.'/'.$filename;
		// check if file exists
		$fs = new FileSystem();
		if (!$fs->exists($filePath)) {
			throw $this->createNotFoundException();
		}
		// prepare BinaryFileResponse
		$response = new BinaryFileResponse($filePath);
		$response->trustXSendfileTypeHeader();
		$response->setContentDisposition(
			ResponseHeaderBag::DISPOSITION_INLINE,
			$filename,
			iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
		);
		return $response;
	}

	/**
	 * @Route("user/document/delete/{userid}/{documentid}", name="documentDelete")
	 */
	public function documentDeleteAction($userid, $documentid) {
		$document = $this->getDoctrine()->getRepository('AppBundle:UserDocument')->find($documentid);
		$em = $this->getDoctrine()->getEntityManager();
		$em->remove($document);
		$em->flush();
		return $this->redirect('/user/view/'.$userid);
	}

	/**
	 * @Route("user/journey/delete/{userid}/{journeyid}", name="journeyDelete")
	 */
	public function journeyDeleteAction($userid, $journeyid) {
		$journey = $this->getDoctrine()->getRepository('AppBundle:UserJourney')->find($journeyid);
		$em = $this->getDoctrine()->getEntityManager();
		$em->remove($journey);
		$em->flush();
		return $this->redirect('/user/view/'.$userid);
	}

	/**
	 * @Route("user/event/delete/{userid}/{eventid}", name="eventDelete")
	 */
	public function eventDeleteAction($userid, $eventid) {
		$event = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->find($eventid);
		$em = $this->getDoctrine()->getEntityManager();
		$em->remove($event);
		$em->flush();
		return $this->redirect('/user/view/'.$userid);
	}

	/**
	 * @Route("/user/event/edit/{id}", name="ajax_formUserEventEdit")
	 */
	public function editUserEventAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$event = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->find($id);
			$formEvent = $this->createForm(UserEventType::class, $event);
			$formsOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->findAll();
			$demsOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->findAll();
			$agents = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array('status' => "agent"));
			return $this->container->get('templating')->renderResponse('user/formUserEventEdit.html.twig', array('formEvent' => $formEvent->createView(), 'formsOrigin' => $formsOrigin, 'demsOrigin' => $demsOrigin, 'agents' => $agents, 'event' => $event) );
		}
	}

	/**
	 * @Route("/user/journey/edit/{id}", name="ajax_formUserJourneyEdit")
	 */
	public function editUserJourneyAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$journey = $this->getDoctrine()->getRepository('AppBundle:UserJourney')->find($id);
			$formJourney = $this->createForm(UserJourneyType::class, $journey);
			$clinics = $this->getDoctrine()->getRepository('AppBundle:Clinic')->findAll();
			return $this->container->get('templating')->renderResponse('user/formUserJourneyEdit.html.twig', array('formJourney' => $formJourney->createView(), 'clinics' => $clinics, 'journey' => $journey) );
		}
	}

	/**
	 * @Route("user/quote/settled/{userid}/{quoteid}/{settle}", name="quoteSettleUpdate")
	 */
	public function quoteSettleUpdateAction($userid, $quoteid, $settle) {
		$quote = $this->getDoctrine()->getRepository('AppBundle:Quote')->find($quoteid);
		$quote->setSettled($settle);
		$em = $this->getDoctrine()->getEntityManager();
		$em->flush();
		return $this->redirect('/user/view/'.$userid);
	}

	/**
	 * @Route("user/quote/{userid}/{quoteid}", name="userQuote")
	 */
	public function quoteAction($userid, $quoteid) {
		$user = $this->getUserObj($userid);
		$quote = $this->getDoctrine()->getRepository('AppBundle:Quote')->find($quoteid);
		return $this->render('user/quote.html.twig', array('user' => $user, 'quote' => $quote) );
	}

	/**
	 * @Route("/user/delete/{id}", name="ajaxUserDelete")
	 */
	public function userDeleteAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$user = $doc->getRepository('AppBundle:User')->find($id);
		$user->setDeleted(1);
		$em->persist($user);
		$em->flush();
		$response = new JsonResponse('');
		return $response;
	}

	/**
	 * @Route("/user/activate/{id}", name="ajaxUserActivate")
	 */
	public function userActivateAction($id) {
		$doc = $this->getDoctrine();
		$em = $doc->getEntityManager();
		$user = $doc->getRepository('AppBundle:User')->find($id);
		$user->setDeleted(0);
		$em->persist($user);
		$em->flush();
		$response = new JsonResponse('');
		return $response;
	}

	/**
	 * @Route("/user/insertFromForm", name="ajaxUserInsertFromForm")
	 */
	public function insertFromFormAction(){
		$request = $this->container->get('request');
		$name = $request->request->get('userName');
		$surname = $request->request->get('userSurname');
		$city = $request->request->get('userCity');
		$email = $request->request->get('userEmail');
		$phone = $request->request->get('userPhone');
		$phone = str_replace('-', '', $phone);
		$phone = str_replace('/', '', $phone);
		$phone = str_replace(')', '', $phone);
		$phone = str_replace('(', '', $phone);
		$phone = str_replace(' ', '', $phone);
		$message = $request->request->get('userMessage');
		$formOrigin = $request->request->get('userFormOrigin');
		$formOriginDomain = $request->request->get('userFormOriginDomain');
		
		$user = $this->getUserObjByEmail($email);
		$formOriginExist = $this->getFormOriginObjByName($formOrigin);

		if($formOriginExist == null){
			$formOriginObj = new FormOrigin();
			$formOriginObj->setFormName($formOrigin);
			$formOriginObj->setFormDomain($formOriginDomain);
			$em = $this->getDoctrine()->getManager();
			$em->persist($formOriginObj);
			$em->flush();
		}

		if($user == null){
			$userManager = $this->container->get('fos_user.user_manager');
			$user = $userManager->createUser();
			$user->setUsername($email);
			$user->setEmail($email);
			$password = random_bytes(10);
			$user->setPlainPassword($password);
			$user->setDeleted(0);
			$user->setEnabled(0);
			$user->setRoles(array('ROLE_USER'));
			$user->setName($name);
			$user->setSurname($surname);
			$user->setPhonenumber($phone);
			$user->setStatus('prospect');
			$user->setSource('website');
			$user->setCityName($city);
			// Update the user
			$userManager->updateUser($user, true);

			$formOriginEvent = $this->getFormOriginObjByName($formOrigin);
			$userEvent = new UserEvent();
			$userEvent->setContactMethod('form');
			$userEvent->setContactReason('commercial');
			$userEvent->setContactOrigin('customer');
			$userEvent->setDate(new \DateTime(date("Y-m-d H:i:s")));
			$userEvent->setMessage(preg_replace( "/\r|\n/", "", $message ));
			$userEvent->setFormOrigin($formOriginEvent[0]);
			$userEvent->setCustomerUser($user);
			$userEvent->setContactOrigin("customer");
			$em = $this->getDoctrine()->getManager();
			$em->persist($userEvent);
			$em->flush();

			/*$userAlert = new Alert();
			$userAlert->setEventDate(new \DateTime(date("Y-m-d H:i:s")));
			$userAlert->setCustomerUser($user);

			$em->persist($userAlert);
			$em->flush();*/
		}

		$response = new Response();
		$response->setContent(json_encode([
			'response' => '',
		]));

		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

}
