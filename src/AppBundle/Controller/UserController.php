<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

		$user = $this->checkUser($id);
		$roles = $this->checkUserRoles($user);

		$form = $this->createFormBuilder($user)
			->add('username', TextType::class, array('label' => 'Username utente:'))
			->add('name', TextType::class, array('label' => 'Nome:'))
			->add('surname', TextType::class, array('label' => 'Cognome:'))
			->add('save', SubmitType::class, array('label' => 'Modifica le informazioni sull\'utente'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user = $form->getData();
			$userManager->updateUser($user, true);

			//return $this->redirectToRoute('task_success');
		}

		return $this->render('user/edit.html.twig', array(
			'user' => $user,
			'roles' => $user->getRoles(),
			'form' => $form->createView(),
			'isSubmitted' => $form->isSubmitted(),
			'isValid' => $form->isValid()
		));
	}

	/**
	 * @Route("/user/view/{id}", name="userView")
	 */
	public function viewAction($id) {
		//edit single user
		//se utente loggato è ROLE_ADMIN allora può modificare se l'oggetto è di tipo ROLE_USER
		//se utente loggato è ROLE_SUPER_ADMIN allora può modificare tutti gli utenti?
		//da sistemare

		$user = $this->checkUser($id);
		$roles = $this->checkUserRoles($user);
		
		return $this->render('user/view.html.twig', array('user' => $user));
	}

	private function checkUser($id) {
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));

		if (!$user) {
			throw $this->createNotFoundException('User not found');
		}

		return $user;
	}

	private function checkUserRoles($user) {
		$loggedUser = $this->getUser();
		$loggedRoles = $loggedUser->getRoles();
		
		$isAdmin = in_array('ROLE_ADMIN', $loggedRoles);
		$isSuperAdmin = in_array('ROLE_SUPER_ADMIN', $loggedRoles);

		$roles = $user->getRoles();

		if ((in_array('ROLE_ADMIN', $roles) || in_array('ROLE_SUPER_ADMIN', $roles)) && !$isSuperAdmin) {
			throw new AccessDeniedException('You need to be a super admin to view this page');
		}

		return $roles;
	}
}
