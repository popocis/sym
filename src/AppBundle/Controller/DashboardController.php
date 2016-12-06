<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DashboardController extends Controller {
	/**
	 * @Route("/", name="dashboard")
	 */
	public function indexAction() {
		if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SUPER_ADMIN')) {
			return $this->renderAdminDashboard();
		}

		return $this->renderUserDashboard();
	}

	private function renderAdminDashboard() {
		return $this->render('dashboard/index_admin.html.twig');
	}

	private function renderUserDashboard() {
		return $this->render('dashboard/index_user.html.twig', array(
			'user' => $this->getUser()));
	}
}
