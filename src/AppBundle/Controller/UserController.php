<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEvent;
use AppBundle\Entity\UserDocument;
use AppBundle\Entity\UserJourney;
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
					$userJourney->setTransportLoadClient(implode(",",$userJourney->getTransportLoadClient()));
					$userJourney->setTransportLoadHc(implode(",",$userJourney->getTransportLoadHc()));
					$userOperator = $this->get('security.token_storage')->getToken()->getUser();
					$userJourney->setAdminUser($userOperator);
					$userJourney->setCustomerUser($user);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userJourney);
					$em->flush();
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
		}
		$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $id), array('date' => 'DESC'));
		$documents = $this->getDoctrine()->getRepository('AppBundle:UserDocument')->findBy(array('customerUser' => $id));
		$journeys = $this->getDoctrine()->getRepository('AppBundle:UserJourney')->findBy(array('customerUser' => $id));
		$agents = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array('status' => "agent"));
		$formsOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->findAll();
		$demsOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->findAll();
		$clinics = $this->getDoctrine()->getRepository('AppBundle:Clinic')->findAll();
		$presentations = $this->getDoctrine()->getRepository('AppBundle:Presentation')->findAll();

		return $this->render('user/view.html.twig', array('user' => $user, 'agents' => $agents, 'formsOrigin' => $formsOrigin, 'demsOrigin' => $demsOrigin, 'userEvents' => $events, 'clinics' => $clinics, 'presentations' => $presentations, 'formEvent' => $formEvent->createView(), 'userDocuments' => $documents, 'formDocument' => $formDocument->createView(), 'userJourneys' => $journeys, 'formJourney' => $formJourney->createView(), 'formUser' => $formUser->createView()));
	}

	private function getUserObj($id) {
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));
		if (!$user) {
			throw $this->createNotFoundException('User not found');
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
}
