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

class DashboardController extends Controller {
	/**
	 * @Route("/", name="dashboard")
	 */
	public function indexAction(Request $request) {
		if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SUPER_ADMIN')) {
			return $this->renderAdminDashboard();
		}

		return $this->renderUserDashboard($request);
	}

	private function renderAdminDashboard() {
		return $this->render('dashboard/index_admin.html.twig');
	}

	private function renderUserDashboard(Request $request) {

		$user = $this->container->get('security.context')->getToken()->getUser();
		$userId = $user->getId();
		$user = $this->getUserObj($userId);
		$formUser = $this->createForm(UserType::class, $user);

		if('POST' === $request->getMethod()) {
			if($request->request->has('user')) {
				$formUser->handleRequest($request);
				if ($formUser->isSubmitted() && $formUser->isValid()) {
					$user = $formUser->getData();
					$userManager = $this->get('fos_user.user_manager');
					$user->setUsername($user->getEmail());
					$userManager->updateUser($user, true);
				}
			}
		}

		return $this->render('dashboard/index_user.html.twig', array( 'formUser' => $formUser->createView(), 'user' => $this->getUser() ));
	}

	private function getUserObj($id) {
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));
		if (!$user) {
			throw $this->createNotFoundException('User not found');
		}
		return $user;
	}

	/**
	 * @Route("/user/edit", name="userEdit")
	 */
	public function userEditAction(Request $request) {
		$user = $this->container->get('security.context')->getToken()->getUser();
		$userId = $user->getId();
		$user = $this->getUserObj($userId);
		$formUser = $this->createForm(UserType::class, $user);

		if('POST' === $request->getMethod()) {
			if($request->request->has('user')) {
				$formUser->handleRequest($request);
				if ($formUser->isSubmitted() && $formUser->isValid()) {
					$user = $formUser->getData();
					$userManager = $this->get('fos_user.user_manager');
					$user->setUsername($user->getEmail());
					$userManager->updateUser($user, true);
				}
			}
		}

		return $this->render('client/edit.html.twig', array( 'formUser' => $formUser->createView(), 'user' => $this->getUser() ));
	}
}
