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

class UserEventType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			 ->add('id', null, array(
				 'mapped' => false
			 ))
			->add('contactMethod', ChoiceType::class, array(
				'choices' => array('phone' => 'phone', 'email' => 'email', 'viber' => 'viber', 'whatsapp' => 'whatsapp', 'facebook' => 'facebook', 'facetime' => 'facetime', 'facetoface' => 'facetoface', 'form' => 'form', 'dem' => 'dem', 'other' => 'other'),
				'choices_as_values' => true,
			))
			->add('contactOrigin', ChoiceType::class, array(
				'choices' => array('customer' => 'customer', 'operator' => 'operator'),
				'choices_as_values' => true,
			))
			->add('contactReason', ChoiceType::class, array(
				'choices' => array('general' => 'general', 'commercial' => 'commercial', 'panorex' => 'panorex', 'estimate' => 'estimate', 'accepted estimate' => 'accepted estimate'),
				'choices_as_values' => true,
			))
			->add('agentUser')
			->add('formOrigin')
			->add('demOrigin')
			->add('message')
			->add('estimate', ChoiceType::class, array(
				'choices' => array('2999' => '2999', '3000' => '3000', '5000' => '5000'),
				'choices_as_values' => true,
			))
			->add('notes')
			->add('date', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('save', SubmitType::class)
			->getForm();
	}

	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\UserEvent',
		));
	}
}