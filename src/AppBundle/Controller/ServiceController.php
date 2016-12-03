<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FormOrigin;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ServiceController extends Controller {
	/**
	 * @Route("/service/add", name="serviceAdd")
	 */
	public function serviceAddAction(Request $request){

		$formOrigin = new FormOrigin();
		$formFormOrigin = $this->createFormBuilder($formOrigin)
			->add('formName')
			->add('formDomain', ChoiceType::class, array(
				'choices' => array('IT' => 'IT', 'COM' => 'COM', 'EU' => 'EU'),
				'choices_as_values' => true,
			))
			->add('save', SubmitType::class)
			->getForm();

		if('POST' === $request->getMethod()) {

			if($request->request->has('formFormOrigin')){
				$formFormOrigin->handleRequest($request);
				if ($formFormOrigin->isSubmitted() && $formFormOrigin->isValid()) {
					$formOrigin = $formFormOrigin->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($formOrigin);
					$em->flush();
				}
			}

		}

		return $this->render('service/add.html.twig', array('formFormOrigin' => $formFormOrigin->createView()));
	}
}