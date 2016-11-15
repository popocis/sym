<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends Controller{

	/**
	 * @Route("/user/edit/{id}", name="userEdit")
	 */
	public function editAction(Request $request, $id){

		//edit single user
		//se utente loggato è ROLE_ADMIN allora può modificare se l'oggetto è di tipo ROLE_USER
		//se utente loggato è ROLE_SUPER_ADMIN allora può modificare tutti gli utenti?
		//da sistemare

		$userManager = $this->get('fos_user.user_manager');

		$user = $userManager->findUserBy(array('id' => $id));

		$form = $this->createFormBuilder($user)
			->add('username', TextType::class, array('label' => 'Username utente:'))
			->add('name', TextType::class, array('label' => 'Nome:'))
			->add('surname', TextType::class, array('label' => 'Cognome:'))
			//->add('dueDate', DateType::class)
			->add('save', SubmitType::class, array('label' => 'Modifica le informazioni sull\'utente'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$user = $form->getData();

			// ... perform some action, such as saving the task to the database
			// for example, if Task is a Doctrine entity, save it!
			// $em = $this->getDoctrine()->getManager();
			// $em->persist($task);
			// $em->flush();

			$userManager->updateUser($user, true);

			//return $this->redirectToRoute('task_success');
		}

		return $this->render('user/edit.html.twig', array(
			'user' => $user,
			'form' => $form->createView(),
			'isSubmitted' => $form->isSubmitted(),
			'isValid' => $form->isValid()
		));
	}

	/**
	 * @Route("/user/view/{id}", name="userView")
	 */
	public function viewAction($id){

		//edit single user
		//se utente loggato è ROLE_ADMIN allora può modificare se l'oggetto è di tipo ROLE_USER
		//se utente loggato è ROLE_SUPER_ADMIN allora può modificare tutti gli utenti?
		//da sistemare

		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));
		return $this->render('user/view.html.twig', array('user' => $user));
	}
}
