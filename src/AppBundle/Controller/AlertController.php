<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AlertController extends Controller {

	/**
	 * @Route("/alert", name="alert")
	 */
	public function indexAction(){
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		$qb->select('e');
		$qb->from('AppBundle:Alert', 'e');
		$qb->where('e.estimateSendDate IS NOT NULL');
		$qb->orderBy('e.estimateSendDate', 'ASC');
		$sendEstimateList = $qb->getQuery()->getResult();

		$qb->select('a');
		$qb->from('AppBundle:Alert', 'a');
		$qb->where('a.estimateRecallDate IS NOT NULL OR a.estimateRecallAttempts !=0');
		$qb->orderBy('a.estimateRecallDate', 'ASC');
		$recallEstimateList = $qb->getQuery()->getResult();

		$qb->select('b');
		$qb->from('AppBundle:Alert', 'b');
		$qb->where('b.interestedLaterDate IS NOT NULL OR b.interestedLaterAttempts !=0');
		$qb->orderBy('b.interestedLaterDate', 'ASC');
		$recallLaterList = $qb->getQuery()->getResult();

		$qb->select('c');
		$qb->from('AppBundle:Alert', 'c');
		$qb->where('c.postTherapyRecallDate IS NOT NULL OR c.postTherapyRecallAttempts !=0');
		$qb->orderBy('c.postTherapyRecallDate', 'ASC');
		$recallPostTherapyList = $qb->getQuery()->getResult();
		
		return $this->render('alert/index.html.twig', array('sendEstimateList'=>$sendEstimateList, 'recallEstimateList'=>$recallEstimateList, 'recallLaterList'=>$recallLaterList, 'recallPostTherapyList'=>$recallPostTherapyList));
	}
}
