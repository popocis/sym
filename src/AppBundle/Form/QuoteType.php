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

class QuoteType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add('id', null, array(
				'mapped' => false
			))
			->add('treatmentSup1')
			->add('treatmentSupQt1')
			->add('treatmentSupFare1')
			->add('treatmentInf1')
			->add('treatmentInfQt1')
			->add('treatmentInfFare1')
			->add('treatmentTotalFare')
			->add('date', DateType::class, array(
				'widget' => 'single_text',
				'html5' => false,
				'format' => 'dd/MM/yyyy',
			))
			->add('notes')
			->add('save', SubmitType::class)
			->getForm();
	}

	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Quote'
		));
	}
}