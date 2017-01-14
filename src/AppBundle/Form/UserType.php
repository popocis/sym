<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('email')
			->add('name')
			->add('surname')
			->add('birthDate', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('phoneNumber')
			->add('streetNumber')
			->add('streetName')
			->add('cityName')
			->add('zipCode')
			->add('countryName')
			->add('countryRegion')
			->add('taxCode')
			->add('status', ChoiceType::class, array(
				'choices' => array('commercial' => 'commercial', 'prospect' => 'prospect', 'client' => 'client', 'interested' => 'interested', 'agent' => 'agent', 'operator' => 'operator'),
				'choices_as_values' => true,
			))
			->add('presentation')
			->add('notes')
			->add('save', SubmitType::class)
			->getForm();
	}

	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User'
		));
	}
}