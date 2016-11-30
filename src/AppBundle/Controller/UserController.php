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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class UserController extends Controller {

	/**
	 * @Route("/{_locale}/user/edit/{id}", name="userEdit")
	 */
	public function editAction(Request $request, $id) {
		//edit single user
		//se utente loggato è ROLE_ADMIN allora può modificare se l'oggetto è di tipo ROLE_USER
		//se utente loggato è ROLE_SUPER_ADMIN allora può modificare tutti gli utenti?
		//da sistemare

		$user = $this->getUserObj($id);
		$userRoles = $this->checkUserRoles($user);
		$loggedUser = $this->getUser();
		$loggedRoles = $loggedUser->getRoles();

		$form = $this->createFormBuilder($user)
			->add('username')
			->add('name')
			->add('surname')
			->add('phoneNumber')
			->add('streetNumber')
			->add('streetName')
			->add('cityName')
			->add('zipCode')
			//->add('countryName', CountryType::class, array('multiple'=>false));
			->add('countryName')
			->add('taxCode')
			->add('status', ChoiceType::class, array(
			'choices' => array('commercial' => 'commercial', 'prospect' => 'prospect', 'client' => 'client', 'operator' => 'operator'),
			'choices_as_values' => true,
			))
			->add('save', SubmitType::class)
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user = $form->getData();
			$userManager = $this->get('fos_user.user_manager');
			$user->setUsername($user->getEmail());
			$userManager->updateUser($user, true);
			return $this->redirect('/user/view/'.$id);
		}

		return $this->render('user/edit.html.twig', array(
			'user' => $user,
			'form' => $form->createView()
		));
	}

	/**
	 * @Route("/{_locale}/user/view/{id}", name="userView")
	 */
	public function viewAction(Request $request, $id) {
		$user = $this->getUserObj($id);

		$userEvent = new UserEvent();
		$formEvent = $this->createFormBuilder($userEvent)
			->add('contactMethod', ChoiceType::class, array(
				'choices' => array('phone' => 'phone', 'email' => 'email', 'viber' => 'viber', 'whatsapp' => 'whatsapp', 'facetime' => 'facetime', 'form' => 'form', 'toll free' => 'toll free'),
				'choices_as_values' => true,
			))
			->add('contactReason', ChoiceType::class, array(
				'choices' => array('general' => 'general', 'commercial' => 'commercial', 'estimate' => 'estimate', 'accepted estimate' => 'accepted estimate'),
				'choices_as_values' => true,
			))
			->add('notes', TextType::class)
			->add('throughOffering', ChoiceType::class, array(
				'choices' => array('false' => 0, 'true' => 1),
				'choices_as_values' => true,
			))
			->add('date', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('save', SubmitType::class)
			->getForm();

		$userDocument = new UserDocument();
		$formDocument = $this->createFormBuilder($userDocument)
			->add('documentType', ChoiceType::class, array(
				'choices' => array('dental panoramic' => 'dentalPanoramic', 'quote' => 'quote', 'document' => 'document', 'other' => 'other'),
				'choices_as_values' => true,
			))
			->add('documentFile', VichFileType::class, array())
			->add('save', SubmitType::class)
			->getForm();

		$userJourney = new UserJourney();
		$formJourney = $this->createFormBuilder($userJourney)
			->add('clinic', ChoiceType::class, array(
				'choices' => array('hc Zagabria' => 'hc Zagabria', 'hc Pola' => 'hc Pola'),
				'choices_as_values' => true,
			))
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
			->add('transport', TextType::class)
			->add('accommodation', TextType::class)
			->add('accommodationAddress', TextType::class)
			->add('notes', TextType::class)
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
					$em = $this->getDoctrine()->getManager();
					$em->persist($userDocument);
					$em->flush();
				}
			}
			elseif($request->request->has('formJourney')) {
				$formJourney->handleRequest($request);
				if ($formJourney->isSubmitted() && $formJourney->isValid()) {
					$userJourney = $formJourney->getData();
					$userOperator = $this->get('security.token_storage')->getToken()->getUser();
					$userJourney->setAdminUser($userOperator);
					$userJourney->setCustomerUser($user);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userJourney);
					$em->flush();
				}
			}
		}
		$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $id));
		$documents = $this->getDoctrine()->getRepository('AppBundle:UserDocument')->findBy(array('customerUser' => $id));
		$journeys = $this->getDoctrine()->getRepository('AppBundle:UserJourney')->findBy(array('customerUser' => $id));
		return $this->render('user/view.html.twig', array('user' => $user, 'userEvents' => $events, 'formEvent' => $formEvent->createView(), 'userDocuments' => $documents, 'formDocument' => $formDocument->createView(), 'userJourneys' => $journeys, 'formJourney' => $formJourney->createView()));
	}

	/**
	 * @Route("/profile", name="userProfile")
	 */
	public function profileAction(Request $request) {
		$user = $this->getUser();

		return $this->render('user/profile.html.twig', array(
			'user' => $user
		));
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
}
