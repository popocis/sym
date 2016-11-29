<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Intl\Intl;

class RegistrationType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){

		$builder->remove('username');
		$builder->remove('plainPassword');
		$builder->add('name');
		$builder->add('surname');
		$builder->add('phoneNumber');
		$builder->add('streetNumber');
		$builder->add('streetName');
		$builder->add('cityName');
		$builder->add('zipCode');
		$builder->add('countryName', CountryType::class, array('multiple'=>false));
		$builder->add('taxCode');
		$builder->add('status', ChoiceType::class, array(
			'choices' => array('commercial' => 'commercial', 'prospect' => 'prospect', 'client' => 'client', 'operator' => 'operator'),
			'choices_as_values' => true,
		));
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