<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller{
	/**
	 * @Route("/user", name="user")
	 */
	//get all users
	public function indexAction(){
		$userManager = $this->get('fos_user.user_manager');
		$users = $userManager->findUsers();
		return $this->render('user/index.html.twig', array('users' => $users));
	}

	/**
	 * @Route("/user/edit/{id}", name="userEdit")
	 */
	//edit single user
	//se utente loggato è ROLE_ADMIN allora può modificare se l'oggetto è di tipo ROLE_USER
	//se utente loggato è ROLE_SUPER_ADMIN allora può modificare tutti gli utenti?
	//da sistemare
	public function editAction($id){
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));
		return $this->render('user/edit.html.twig', array('user' => $user));
	}

}
