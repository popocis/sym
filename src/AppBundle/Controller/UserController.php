<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends Controller {

	/**
	 * @Route("/user/edit/{id}", name="userEdit")
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
			$userManager->updateUser($user, true);
			//Redirect to user view
			//return $this->redirectToRoute('task_success');
		}

		return $this->render('user/edit.html.twig', array(
			'user' => $user,
			'form' => $form->createView()
		));
	}

	/**
	 * @Route("/user/view/{id}", name="userView")
	 */
	public function viewAction(Request $request, $id) {

		$user = $this->getUserObj($id);

		// just setup a fresh $userEvent object
		$userEvent = new UserEvent();

		$form = $this->createFormBuilder($userEvent)
			->add('contactMethod', ChoiceType::class, array(
				'choices' => array('phone' => 'phone', 'email' => 'email', 'viber' => 'viber', 'whatsapp' => 'whatsapp'),
				'choices_as_values' => true,
			))
			->add('contactReason', ChoiceType::class, array(
				'choices' => array('general' => 'general', 'commercial' => 'commercial', 'estimate' => 'estimate', 'accepted estimate' => 'acceptedEstimate'),
				'choices_as_values' => true,
			))
			->add('notes', TextType::class)
			->add('date', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyy',
			))
			->add('save', SubmitType::class, array('label' => 'Save Event'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$userEvent = $form->getData();

			$userOperator = $this->get('security.token_storage')->getToken()->getUser();
			//echo $userOperator->getId();

			$userEvent->setAdminUser($userOperator);
			$userEvent->setCustomerUser($user);
			
			// ... perform some action, such as saving the task to the database
			// for example, if Task is a Doctrine entity, save it!
			$em = $this->getDoctrine()->getManager();
			$em->persist($userEvent);
			$em->flush();
		}

		$events = $this->getDoctrine()->getRepository('AppBundle:UserEvent')->findBy(array('customerUser' => $id));

		return $this->render('user/view.html.twig', array('user' => $user, 'userEvents' => $events, 'form' => $form->createView()));
	}

	/**
	 * @Route("/profile", name="userProfile")
	 */
	public function profileAction(Request $request) {
		$user = $this->getUser();

		$form = $this->createFormBuilder($user)
			->add('phoneNumber')
			->add('taxCode')
			->add('save', SubmitType::class)
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user = $form->getData();

			$userManager = $this->get('fos_user.user_manager');
			$userManager->updateUser($user, true);
			//Redirect to user view
			//return $this->redirectToRoute('task_success');
		}

		return $this->render('user/profile.html.twig', array(
			'user' => $user,
			'form' => $form->createView()
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
		//resitutisci i ruoli per utente passato
		$roles = $user->getRoles();
		return $roles;
	}
}
