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

class UserController extends Controller {



	/**
	 * @Route("/user/view/{id}", name="userView")
	 */
	public function viewAction(Request $request, $id) {
		$user = $this->getUserObj($id);

		$formUser = $this->createFormBuilder($user)
			->add('email')
			->add('name')
			->add('surname')
			->add('birthDate', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('phoneNumber')
			->add('streetNumber')
			->add('streetName')
			->add('cityName')
			->add('zipCode')
			->add('countryName')
			->add('countryRegion')
			->add('taxCode')
			->add('status', ChoiceType::class, array(
				'choices' => array('commercial' => 'commercial', 'prospect' => 'prospect', 'client' => 'client', 'operator' => 'operator'),
				'choices_as_values' => true,
			))
			->add('save', SubmitType::class)
			->getForm();

		$userEvent = new UserEvent();
		$formEvent = $this->createFormBuilder($userEvent)
			->add('contactMethod', ChoiceType::class, array(
				'choices' => array('phone' => 'phone', 'email' => 'email', 'viber' => 'viber', 'whatsapp' => 'whatsapp', 'facetime' => 'facetime', 'form' => 'form'),
				'choices_as_values' => true,
			))
			->add('contactReason', ChoiceType::class, array(
				'choices' => array('general' => 'general', 'commercial' => 'commercial', 'estimate' => 'estimate', 'accepted estimate' => 'accepted estimate'),
				'choices_as_values' => true,
			))
			->add('agentUser')
			->add('formOrigin')
			->add('demOrigin')
			->add('notes')
			->add('date', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('save', SubmitType::class)
			->getForm();

		$userDocument = new UserDocument();
		$formDocument = $this->createFormBuilder($userDocument)
			->add('name')
			->add('documentType', ChoiceType::class, array(
				'choices' => array('dental panoramic' => 'panoramic', 'quote' => 'quote', 'id document' => 'id', 'other document' => 'other'),
				'choices_as_values' => true,
			))
			->add('documentFile', VichFileType::class, array())
			->add('save', SubmitType::class)
			->getForm();

		$userJourney = new UserJourney();
		$formJourney = $this->createFormBuilder($userJourney)
			->add('clinic')
			->add('arrivalDate', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('appointmentDate', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('departureDate', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('nightLoadClient')
			->add('nightLoadHc')
			->add('transportLoadClient')
			->add('transportLoadHc')
			->add('accommodation')
			->add('accommodationAddress')
			->add('notes')
			->add('save', SubmitType::class)
			->getForm();


		if('POST' === $request->getMethod()) {

			if($request->request->has('formEvent')){
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
			elseif($request->request->has('formDocument')) {
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
			elseif($request->request->has('formJourney')) {
				$formJourney->handleRequest($request);
				if ($formJourney->isSubmitted() && $formJourney->isValid()) {
					$userJourney = $formJourney->getData();
					$userJourney->setTransportLoadClient(implode(", ",$userJourney->getTransportLoadClient()));
					$userJourney->setTransportLoadHc(implode(", ",$userJourney->getTransportLoadHc()));
					$userOperator = $this->get('security.token_storage')->getToken()->getUser();
					$userJourney->setAdminUser($userOperator);
					$userJourney->setCustomerUser($user);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userJourney);
					$em->flush();
				}
			}
			elseif($request->request->has('formUser')) {
				$formUser->handleRequest($request);
				if ($formUser->isSubmitted() && $formUser->isValid()) {
					$user = $formUser->getData();
					$userManager = $this->get('fos_user.user_manager');
					$user->setUsername($user->getEmail());
					$userManager->updateUser($user, true);
				}
			}
		}
		$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $id));
		$documents = $this->getDoctrine()->getRepository('AppBundle:UserDocument')->findBy(array('customerUser' => $id));
		$journeys = $this->getDoctrine()->getRepository('AppBundle:UserJourney')->findBy(array('customerUser' => $id));
		$agents = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array('status' => "agent"));
		$formsOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->findAll();
		$demsOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->findAll();
		$clinics = $this->getDoctrine()->getRepository('AppBundle:Clinic')->findAll();
		return $this->render('user/view.html.twig', array('user' => $user, 'agents' => $agents, 'formsOrigin' => $formsOrigin, 'demsOrigin' => $demsOrigin, 'userEvents' => $events, 'clinics' => $clinics, 'formEvent' => $formEvent->createView(), 'userDocuments' => $documents, 'formDocument' => $formDocument->createView(), 'userJourneys' => $journeys, 'formJourney' => $formJourney->createView(), 'formUser' => $formUser->createView()));
	}

	private function getUserObj($id) {
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));
		if (!$user) {
			throw $this->createNotFoundException('User not found');
		}
		return $user;
	}

	private function checkUserRoles($user) {
		$roles = $user->getRoles();
		return $roles;
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
	 * @Route("/document/delete/{userid}/{documentid}", name="documentDelete")
	 */
	public function documentDeleteAction($userid, $documentid) {
		$document = $this->getDoctrine()->getRepository('AppBundle:UserDocument')->find($documentid);
		$em = $this->getDoctrine()->getEntityManager();
		$em->remove($document);
		$em->flush();
		return $this->redirect('/user/view/'.$userid);
	}
}
