<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CalendarController extends Controller {
	/**
	 * @Route("/calendar", name="calendar")
	 */
	public function indexAction() {
		return $this->render('calendar/index.html.twig');
	}
}
