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
			->add('language', ChoiceType::class, array(
				'choices' => array('it' => 'it', 'gb' => 'gb'),
				'choices_as_values' => true,
			))
			->add('treatmentSup1')
			->add('treatmentSupQt1')
			->add('treatmentSupFare1')
			->add('treatmentSupTeeth1')
			->add('treatmentSup2')
			->add('treatmentSupQt2')
			->add('treatmentSupFare2')
			->add('treatmentSupTeeth2')
			->add('treatmentSup3')
			->add('treatmentSupQt3')
			->add('treatmentSupFare3')
			->add('treatmentSupTeeth3')
			->add('treatmentSup4')
			->add('treatmentSupQt4')
			->add('treatmentSupFare4')
			->add('treatmentSupTeeth4')
			->add('treatmentSup5')
			->add('treatmentSupQt5')
			->add('treatmentSupFare5')
			->add('treatmentSupTeeth5')
			->add('treatmentSup6')
			->add('treatmentSupQt6')
			->add('treatmentSupFare6')
			->add('treatmentSupTeeth6')
			->add('treatmentSup7')
			->add('treatmentSupQt7')
			->add('treatmentSupFare7')
			->add('treatmentSupTeeth7')
			->add('treatmentSup8')
			->add('treatmentSupQt8')
			->add('treatmentSupFare8')
			->add('treatmentSupTeeth8')
			->add('treatmentSup9')
			->add('treatmentSupQt9')
			->add('treatmentSupFare9')
			->add('treatmentSupTeeth9')
			->add('treatmentSup10')
			->add('treatmentSupQt10')
			->add('treatmentSupFare10')
			->add('treatmentSupTeeth10')
			->add('treatmentInf1')
			->add('treatmentInfQt1')
			->add('treatmentInfFare1')
			->add('treatmentInfTeeth1')
			->add('treatmentInf2')
			->add('treatmentInfQt2')
			->add('treatmentInfFare2')
			->add('treatmentInfTeeth2')
			->add('treatmentInf3')
			->add('treatmentInfQt3')
			->add('treatmentInfFare3')
			->add('treatmentInfTeeth3')
			->add('treatmentInf4')
			->add('treatmentInfQt4')
			->add('treatmentInfFare4')
			->add('treatmentInfTeeth4')
			->add('treatmentInf5')
			->add('treatmentInfQt5')
			->add('treatmentInfFare5')
			->add('treatmentInfTeeth5')
			->add('treatmentInf6')
			->add('treatmentInfQt6')
			->add('treatmentInfFare6')
			->add('treatmentInfTeeth6')
			->add('treatmentInf7')
			->add('treatmentInfQt7')
			->add('treatmentInfFare7')
			->add('treatmentInfTeeth7')
			->add('treatmentInf8')
			->add('treatmentInfQt8')
			->add('treatmentInfFare8')
			->add('treatmentInfTeeth8')
			->add('treatmentInf9')
			->add('treatmentInfQt9')
			->add('treatmentInfFare9')
			->add('treatmentInfTeeth9')
			->add('treatmentInf10')
			->add('treatmentInfQt10')
			->add('treatmentInfFare10')
			->add('treatmentInfTeeth10')
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