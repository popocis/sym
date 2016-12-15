<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DemOrigin;
use AppBundle\Entity\FormOrigin;
use AppBundle\Entity\Clinic;
use AppBundle\Entity\Presentation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\FormOriginType;
use AppBundle\Form\ClinicType;
use AppBundle\Form\DemOriginType;
use AppBundle\Form\PresentationType;

class ServiceController extends Controller {
	/**
	 * @Route("/service/add", name="serviceAdd")
	 */
	public function serviceAddAction(Request $request){

		$formOriginId = isset($request->request->get('form_origin')['id']) ? $request->request->get('form_origin')['id'] : null;
		if (!is_null($formOriginId)){
			$formOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->find($formOriginId);
		} else {
			$formOrigin = new FormOrigin();
		}
		$formFormOrigin = $this->createForm(FormOriginType::class, $formOrigin);

		$clinicId = isset($request->request->get('clinic')['id']) ? $request->request->get('clinic')['id'] : null;
		if (!is_null($clinicId)){
			$clinic = $this->getDoctrine()->getRepository('AppBundle:Clinic')->find($clinicId);
		} else {
			$clinic = new Clinic();
		}
		$formClinic = $this->createForm(ClinicType::class, $clinic);

		$demOriginId = isset($request->request->get('dem_origin')['id']) ? $request->request->get('dem_origin')['id'] : null;
		if (!is_null($demOriginId)){
			$demOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->find($demOriginId);
		} else {
			$demOrigin = new DemOrigin();
		}
		$formDemOrigin = $this->createForm(DemOriginType::class, $demOrigin);

		$presentationId = isset($request->request->get('presentation')['id']) ? $request->request->get('presentation')['id'] : null;
		if (!is_null($presentationId)){
			$presentation = $this->getDoctrine()->getRepository('AppBundle:Presentation')->find($presentationId);
		} else {
			$presentation = new Presentation();
		}
		$formPresentation = $this->createForm(PresentationType::class, $presentation);


		if('POST' === $request->getMethod()) {
			if($request->request->has('form_origin')){
				$formFormOrigin->handleRequest($request);
				if ($formFormOrigin->isSubmitted() && $formFormOrigin->isValid()) {
					$formOrigin = $formFormOrigin->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($formOrigin);
					$em->flush();
				}
			}
			elseif($request->request->has('clinic')) {
				$formClinic->handleRequest($request);
				if ($formClinic->isSubmitted() && $formClinic->isValid()) {
					$clinic = $formClinic->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($clinic);
					$em->flush();
				}
			}
			elseif($request->request->has('dem_origin')) {
				$formDemOrigin->handleRequest($request);
				if ($formDemOrigin->isSubmitted() && $formDemOrigin->isValid()) {
					$demOrigin = $formDemOrigin->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($demOrigin);
					$em->flush();
				}
			}
			elseif($request->request->has('presentation')) {
				$formPresentation->handleRequest($request);
				if ($formPresentation->isSubmitted() && $formPresentation->isValid()) {
					$presentation = $formPresentation->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($presentation);
					$em->flush();
				}
			}
		}

		$formsOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->findAll();
		$demsOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->findAll();
		$clinics = $this->getDoctrine()->getRepository('AppBundle:Clinic')->findAll();
		$presentations = $this->getDoctrine()->getRepository('AppBundle:Presentation')->findAll();

		return $this->render('service/add.html.twig', array( 'clinics' => $clinics, 'presentations' => $presentations, 'formsOrigin' => $formsOrigin, 'demsOrigin' => $demsOrigin, 'formFormOrigin' => $formFormOrigin->createView(), 'formClinic' => $formClinic->createView(), 'formDemOrigin' => $formDemOrigin->createView(), 'formPresentation' => $formPresentation->createView() ));
	}

	/**
	 * @Route("/service/formorigin/edit/{id}", name="ajax_formFormOriginEdit")
	 */
	public function editFormOriginAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$formOrigin = $this->getDoctrine()->getRepository('AppBundle:FormOrigin')->find($id);
			$formFormOrigin = $this->createForm(FormOriginType::class, $formOrigin);
			return $this->container->get('templating')->renderResponse('service/formFormOriginEdit.html.twig', array('formFormOrigin' => $formFormOrigin->createView(), 'formOrigin' => $formOrigin ));
		}
	}

	/**
	 * @Route("/service/clinic/edit/{id}", name="ajax_formClinicEdit")
	 */
	public function editClinicAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$clinic = $this->getDoctrine()->getRepository('AppBundle:Clinic')->find($id);
			$formClinic = $this->createForm(ClinicType::class, $clinic);
			return $this->container->get('templating')->renderResponse('service/formClinicEdit.html.twig', array('formClinic' => $formClinic->createView(), 'clinic' => $clinic ));
		}
	}

	/**
	 * @Route("/service/demorigin/edit/{id}", name="ajax_formDemOriginEdit")
	 */
	public function editDemOriginAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$demOrigin = $this->getDoctrine()->getRepository('AppBundle:DemOrigin')->find($id);
			$formDemOrigin = $this->createForm(DemOriginType::class, $demOrigin);
			return $this->container->get('templating')->renderResponse('service/formDemOriginEdit.html.twig', array('formDemOrigin' => $formDemOrigin->createView(), 'demOrigin' => $demOrigin ));
		}
	}

	/**
	 * @Route("/service/presentation/edit/{id}", name="ajax_formPresentationEdit")
	 */
	public function editPresentationAction($id){
		if ($this->container->get('request')->isXmlHttpRequest()) {
			$presentation = $this->getDoctrine()->getRepository('AppBundle:Presentation')->find($id);
			$formPresentation = $this->createForm(PresentationType::class, $presentation);
			return $this->container->get('templating')->renderResponse('service/formPresentationEdit.html.twig', array('formPresentation' => $formPresentation->createView(), 'presentation' => $presentation ));
		}
	}

}

