<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class RegistrationType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){

		$builder->remove('username');
		$builder->remove('plainPassword');
		$builder->add('name');
		$builder->add('surname');
		$builder->add('birthDate', DateType::class, array(
			'widget' => 'single_text',
			'html5' => false,
			'format' => 'dd/MM/yyyy',
		));
		$builder->add('phoneNumber');
		$builder->add('streetName');
		$builder->add('cityName');
		$builder->add('zipCode');
		$builder->add('countryName', CountryType::class, array('multiple'=>false));
		$builder->add('countryRegion');
		$builder->add('taxCode');
		$builder->add('status', ChoiceType::class, array(
			'choices' => array('prospect' => 'prospect', 'client' => 'client', 'interested' => 'interested', 'operator' => 'operator', 'agent' => 'agent'),
			'choices_as_values' => true,
		));
		$builder->add('source', ChoiceType::class, array(
			'choices' => array('website' => 'website', 'dem' => 'dem', 'facebook' => 'facebook', 'agent' => 'agent', 'wordofmouth' => 'wordofmouth', 'presentation' => 'presentation', 'other' => 'other'),
			'choices_as_values' => true,
		));
		$builder->add('demOrigin');
		$builder->add('presentation');
		$builder->add('agentUser', 'entity', array(
			'class' => 'AppBundle:User',
			'required' => false,
			'query_builder' => function(EntityRepository $repository) {
				$qb = $repository->createQueryBuilder('u');
				return $qb
					->where($qb->expr()->eq('u.status', ':status'))
					->setParameter('status', 'agent');
			},
		));
		$builder->add('notes');
	}

	public function getParent(){
		return 'FOS\UserBundle\Form\Type\RegistrationFormType';
	}

	public function getBlockPrefix(){
		return 'app_user_registration';
	}

	// For Symfony 2.x
	public function getName(){
		return $this->getBlockPrefix();
	}
}