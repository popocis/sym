<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->remove('username');
		$builder->add('name');
		$builder->add('surname');
		$builder->add('phoneNumber');
	}

	public function getParent(){
		return 'FOS\UserBundle\Form\Type\ProfileFormType';
	}

	public function getBlockPrefix(){
		return 'app_user_registration';
	}

	// For Symfony 2.x
	public function getName(){
		return $this->getBlockPrefix();
	}
}