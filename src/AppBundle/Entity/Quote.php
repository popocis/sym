<?php
// src/AppBundle/Entity/Quote.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="quote")
 */
class Quote{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="admin_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $adminUser;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="client_user_id", referencedColumnName="id", nullable=false)
	 */
	protected $customerUser;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Choice(choices = {"it", "gb"}, message = "Choose a valid language.")
	 */
	protected $language;

	/**
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected $quoteNr;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $settled;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_1_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup1;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt1;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth1;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare1;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_2_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup2;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt2;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth2;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare2;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_3_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup3;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt3;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth3;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare3;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_4_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup4;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt4;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth4;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare4;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_5_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup5;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt5;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth5;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare5;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_6_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup6;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt6;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth6;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare6;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_7_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup7;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt7;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth7;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare7;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_8_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup8;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt8;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth8;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare8;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_9_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup9;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt9;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth9;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare9;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_sup_10_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentSup10;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentSupQt10;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentSupTeeth10;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentSupFare10;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_1_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf1;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt1;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare1;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth1;


	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_2_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf2;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt2;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare2;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth2;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_3_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf3;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt3;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare3;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth3;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_4_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf4;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt4;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare4;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth4;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_5_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf5;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt5;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare5;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth5;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_6_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf6;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt6;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare6;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth6;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_7_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf7;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt7;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare7;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth7;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_8_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf8;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt8;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare8;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth8;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_9_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf9;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt9;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare9;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth9;

	/**
	 * @ORM\ManyToOne(targetEntity="Treatment")
	 * @ORM\JoinColumn(name="treatment_inf_10_id", referencedColumnName="id", nullable=true)
	 */
	protected $treatmentInf10;

	/**
	 * @ORM\Column(type="integer", length=2, nullable=true)
	 */
	protected $treatmentInfQt10;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $treatmentInfFare10;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $treatmentInfTeeth10;

	/**
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected $treatmentTotalFare;

	/**
	 * @ORM\Column(type="date", nullable=false)
	 */
	protected $date;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $notes;

	public function __construct() {

	}

	public function getId() {
		return $this->id;
	}

	public function getAdminUser() {
		return $this->adminUser;
	}

	public function getCustomerUser() {
		return $this->customerUser;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function getQuoteNr() {
		return $this->quoteNr;
	}

	public function getSettled() {
		return $this->settled;
	}

	public function getTreatmentSup1() {
		return $this->treatmentSup1;
	}

	public function getTreatmentSupQt1() {
		return $this->treatmentSupQt1;
	}

	public function getTreatmentSupFare1() {
		return $this->treatmentSupFare1;
	}

	public function getTreatmentSupTeeth1() {
		return $this->treatmentSupTeeth1;
	}

	public function getTreatmentSup2() {
		return $this->treatmentSup2;
	}

	public function getTreatmentSupQt2() {
		return $this->treatmentSupQt2;
	}

	public function getTreatmentSupFare2() {
		return $this->treatmentSupFare2;
	}

	public function getTreatmentSupTeeth2() {
		return $this->treatmentSupTeeth2;
	}

	public function getTreatmentSup3() {
		return $this->treatmentSup3;
	}

	public function getTreatmentSupQt3() {
		return $this->treatmentSupQt3;
	}

	public function getTreatmentSupFare3() {
		return $this->treatmentSupFare3;
	}

	public function getTreatmentSupTeeth3() {
		return $this->treatmentSupTeeth3;
	}

	public function getTreatmentSup4() {
		return $this->treatmentSup4;
	}

	public function getTreatmentSupQt4() {
		return $this->treatmentSupQt4;
	}

	public function getTreatmentSupFare4() {
		return $this->treatmentSupFare4;
	}

	public function getTreatmentSupTeeth4() {
		return $this->treatmentSupTeeth4;
	}

	public function getTreatmentSup5() {
		return $this->treatmentSup5;
	}

	public function getTreatmentSupQt5() {
		return $this->treatmentSupQt5;
	}

	public function getTreatmentSupFare5() {
		return $this->treatmentSupFare5;
	}

	public function getTreatmentSupTeeth5() {
		return $this->treatmentSupTeeth5;
	}

	public function getTreatmentSup6() {
		return $this->treatmentSup6;
	}

	public function getTreatmentSupQt6() {
		return $this->treatmentSupQt6;
	}

	public function getTreatmentSupFare6() {
		return $this->treatmentSupFare6;
	}

	public function getTreatmentSupTeeth6() {
		return $this->treatmentSupTeeth6;
	}

	public function getTreatmentSup7() {
		return $this->treatmentSup7;
	}

	public function getTreatmentSupQt7() {
		return $this->treatmentSupQt7;
	}

	public function getTreatmentSupFare7() {
		return $this->treatmentSupFare7;
	}

	public function getTreatmentSupTeeth7() {
		return $this->treatmentSupTeeth7;
	}

	public function getTreatmentSup8() {
		return $this->treatmentSup8;
	}

	public function getTreatmentSupQt8() {
		return $this->treatmentSupQt8;
	}

	public function getTreatmentSupFare8() {
		return $this->treatmentSupFare8;
	}

	public function getTreatmentSupTeeth8() {
		return $this->treatmentSupTeeth8;
	}

	public function getTreatmentSup9() {
		return $this->treatmentSup9;
	}

	public function getTreatmentSupQt9() {
		return $this->treatmentSupQt9;
	}

	public function getTreatmentSupFare9() {
		return $this->treatmentSupFare9;
	}

	public function getTreatmentSupTeeth9() {
		return $this->treatmentSupTeeth9;
	}

	public function getTreatmentSup10() {
		return $this->treatmentSup10;
	}

	public function getTreatmentSupQt10() {
		return $this->treatmentSupQt10;
	}

	public function getTreatmentSupFare10() {
		return $this->treatmentSupFare10;
	}

	public function getTreatmentSupTeeth10() {
		return $this->treatmentSupTeeth10;
	}

	public function getTreatmentInf1() {
		return $this->treatmentInf1;
	}

	public function getTreatmentInfQt1() {
		return $this->treatmentInfQt1;
	}

	public function getTreatmentInfFare1() {
		return $this->treatmentInfFare1;
	}

	public function getTreatmentInfTeeth1() {
		return $this->treatmentInfTeeth1;
	}

	public function getTreatmentInf2() {
		return $this->treatmentInf2;
	}

	public function getTreatmentInfQt2() {
		return $this->treatmentInfQt2;
	}

	public function getTreatmentInfFare2() {
		return $this->treatmentInfFare2;
	}

	public function getTreatmentInfTeeth2() {
		return $this->treatmentInfTeeth2;
	}

	public function getTreatmentInf3() {
		return $this->treatmentInf3;
	}

	public function getTreatmentInfQt3() {
		return $this->treatmentInfQt3;
	}

	public function getTreatmentInfFare3() {
		return $this->treatmentInfFare3;
	}

	public function getTreatmentInfTeeth3() {
		return $this->treatmentInfTeeth3;
	}

	public function getTreatmentInf4() {
		return $this->treatmentInf4;
	}

	public function getTreatmentInfQt4() {
		return $this->treatmentInfQt4;
	}

	public function getTreatmentInfFare4() {
		return $this->treatmentInfFare4;
	}

	public function getTreatmentInfTeeth4() {
		return $this->treatmentInfTeeth4;
	}

	public function getTreatmentInf5() {
		return $this->treatmentInf5;
	}

	public function getTreatmentInfQt5() {
		return $this->treatmentInfQt5;
	}

	public function getTreatmentInfFare5() {
		return $this->treatmentInfFare5;
	}

	public function getTreatmentInfTeeth5() {
		return $this->treatmentInfTeeth5;
	}

	public function getTreatmentInf6() {
		return $this->treatmentInf6;
	}

	public function getTreatmentInfQt6() {
		return $this->treatmentInfQt6;
	}

	public function getTreatmentInfFare6() {
		return $this->treatmentInfFare6;
	}

	public function getTreatmentInfTeeth6() {
		return $this->treatmentInfTeeth6;
	}

	public function getTreatmentInf7() {
		return $this->treatmentInf7;
	}

	public function getTreatmentInfQt7() {
		return $this->treatmentInfQt7;
	}

	public function getTreatmentInfFare7() {
		return $this->treatmentInfFare7;
	}

	public function getTreatmentInfTeeth7() {
		return $this->treatmentInfTeeth7;
	}

	public function getTreatmentInf8() {
		return $this->treatmentInf8;
	}

	public function getTreatmentInfQt8() {
		return $this->treatmentInfQt8;
	}

	public function getTreatmentInfFare8() {
		return $this->treatmentInfFare8;
	}

	public function getTreatmentInfTeeth8() {
		return $this->treatmentInfTeeth8;
	}

	public function getTreatmentInf9() {
		return $this->treatmentInf9;
	}

	public function getTreatmentInfQt9() {
		return $this->treatmentInfQt9;
	}

	public function getTreatmentInfFare9() {
		return $this->treatmentInfFare9;
	}

	public function getTreatmentInfTeeth9() {
		return $this->treatmentInfTeeth9;
	}

	public function getTreatmentInf10() {
		return $this->treatmentInf10;
	}

	public function getTreatmentInfQt10() {
		return $this->treatmentInfQt10;
	}

	public function getTreatmentInfFare10() {
		return $this->treatmentInfFare10;
	}

	public function getTreatmentInfTeeth10() {
		return $this->treatmentInfTeeth10;
	}

	public function getTreatmentTotalFare() {
		return $this->treatmentTotalFare;
	}

	public function getDate() {
		return $this->date;
	}

	public function getNotes() {
		return $this->notes;
	}

	public function setAdminUser($adminUser) {
		$this->adminUser = $adminUser;
		return $this;
	}

	public function setCustomerUser($customerUser) {
		$this->customerUser = $customerUser;
		return $this;
	}

	public function setLanguage($language) {
		$this->language = $language;
		return $this;
	}

	public function setQuoteNr($quoteNr) {
		$this->quoteNr = $quoteNr;
		return $this;
	}

	public function setSettled($settled) {
		$this->settled = $settled;
		return $this;
	}

	public function setTreatmentSup1($treatmentSup1) {
		$this->treatmentSup1 = $treatmentSup1;
		return $this;
	}

	public function setTreatmentSupQt1($treatmentSupQt1) {
		$this->treatmentSupQt1 = $treatmentSupQt1;
		return $this;
	}

	public function setTreatmentSupFare1($treatmentSupFare1) {
		$this->treatmentSupFare1 = $treatmentSupFare1;
		return $this;
	}

	public function setTreatmentSupTeeth1($treatmentSupTeeth1) {
		$this->treatmentSupTeeth1 = $treatmentSupTeeth1;
		return $this;
	}

	public function setTreatmentSup2($treatmentSup2) {
		$this->treatmentSup2 = $treatmentSup2;
		return $this;
	}

	public function setTreatmentSupQt2($treatmentSupQt2) {
		$this->treatmentSupQt2 = $treatmentSupQt2;
		return $this;
	}

	public function setTreatmentSupFare2($treatmentSupFare2) {
		$this->treatmentSupFare2 = $treatmentSupFare2;
		return $this;
	}

	public function setTreatmentSupTeeth2($treatmentSupTeeth2) {
		$this->treatmentSupTeeth2 = $treatmentSupTeeth2;
		return $this;
	}

	public function setTreatmentSup3($treatmentSup3) {
		$this->treatmentSup3 = $treatmentSup3;
		return $this;
	}

	public function setTreatmentSupQt3($treatmentSupQt3) {
		$this->treatmentSupQt3 = $treatmentSupQt3;
		return $this;
	}

	public function setTreatmentSupFare3($treatmentSupFare3) {
		$this->treatmentSupFare3 = $treatmentSupFare3;
		return $this;
	}

	public function setTreatmentSupTeeth3($treatmentSupTeeth3) {
		$this->treatmentSupTeeth3 = $treatmentSupTeeth3;
		return $this;
	}

	public function setTreatmentSup4($treatmentSup4) {
		$this->treatmentSup4 = $treatmentSup4;
		return $this;
	}

	public function setTreatmentSupQt4($treatmentSupQt4) {
		$this->treatmentSupQt4 = $treatmentSupQt4;
		return $this;
	}

	public function setTreatmentSupFare4($treatmentSupFare4) {
		$this->treatmentSupFare4 = $treatmentSupFare4;
		return $this;
	}

	public function setTreatmentSupTeeth4($treatmentSupTeeth4) {
		$this->treatmentSupTeeth4 = $treatmentSupTeeth4;
		return $this;
	}

	public function setTreatmentSup5($treatmentSup5) {
		$this->treatmentSup5 = $treatmentSup5;
		return $this;
	}

	public function setTreatmentSupQt5($treatmentSupQt5) {
		$this->treatmentSupQt5 = $treatmentSupQt5;
		return $this;
	}

	public function setTreatmentSupFare5($treatmentSupFare5) {
		$this->treatmentSupFare5 = $treatmentSupFare5;
		return $this;
	}

	public function setTreatmentSupTeeth5($treatmentSupTeeth5) {
		$this->treatmentSupTeeth5 = $treatmentSupTeeth5;
		return $this;
	}

	public function setTreatmentSup6($treatmentSup6) {
		$this->treatmentSup6 = $treatmentSup6;
		return $this;
	}

	public function setTreatmentSupQt6($treatmentSupQt6) {
		$this->treatmentSupQt6 = $treatmentSupQt6;
		return $this;
	}

	public function setTreatmentSupFare6($treatmentSupFare6) {
		$this->treatmentSupFare6 = $treatmentSupFare6;
		return $this;
	}

	public function setTreatmentSupTeeth6($treatmentSupTeeth6) {
		$this->treatmentSupTeeth6 = $treatmentSupTeeth6;
		return $this;
	}

	public function setTreatmentSup7($treatmentSup7) {
		$this->treatmentSup7 = $treatmentSup7;
		return $this;
	}

	public function setTreatmentSupQt7($treatmentSupQt7) {
		$this->treatmentSupQt7 = $treatmentSupQt7;
		return $this;
	}

	public function setTreatmentSupFare7($treatmentSupFare7) {
		$this->treatmentSupFare7 = $treatmentSupFare7;
		return $this;
	}

	public function setTreatmentSupTeeth7($treatmentSupTeeth7) {
		$this->treatmentSupTeeth7 = $treatmentSupTeeth7;
		return $this;
	}

	public function setTreatmentSup8($treatmentSup8) {
		$this->treatmentSup8 = $treatmentSup8;
		return $this;
	}

	public function setTreatmentSupQt8($treatmentSupQt8) {
		$this->treatmentSupQt8 = $treatmentSupQt8;
		return $this;
	}

	public function setTreatmentSupFare8($treatmentSupFare8) {
		$this->treatmentSupFare8 = $treatmentSupFare8;
		return $this;
	}

	public function setTreatmentSupTeeth8($treatmentSupTeeth8) {
		$this->treatmentSupTeeth8 = $treatmentSupTeeth8;
		return $this;
	}

	public function setTreatmentSup9($treatmentSup9) {
		$this->treatmentSup9 = $treatmentSup9;
		return $this;
	}

	public function setTreatmentSupQt9($treatmentSupQt9) {
		$this->treatmentSupQt9 = $treatmentSupQt9;
		return $this;
	}

	public function setTreatmentSupFare9($treatmentSupFare9) {
		$this->treatmentSupFare9 = $treatmentSupFare9;
		return $this;
	}

	public function setTreatmentSupTeeth9($treatmentSupTeeth9) {
		$this->treatmentSupTeeth9 = $treatmentSupTeeth9;
		return $this;
	}

	public function setTreatmentSup10($treatmentSup10) {
		$this->treatmentSup10 = $treatmentSup10;
		return $this;
	}

	public function setTreatmentSupQt10($treatmentSupQt10) {
		$this->treatmentSupQt10 = $treatmentSupQt10;
		return $this;
	}

	public function setTreatmentSupFare10($treatmentSupFare10) {
		$this->treatmentSupFare10 = $treatmentSupFare10;
		return $this;
	}

	public function setTreatmentSupTeeth10($treatmentSupTeeth10) {
		$this->treatmentSupTeeth10 = $treatmentSupTeeth10;
		return $this;
	}

	public function setTreatmentInf1($treatmentInf1) {
		$this->treatmentInf1 = $treatmentInf1;
		return $this;
	}

	public function setTreatmentInfQt1($treatmentInfQt1) {
		$this->treatmentInfQt1 = $treatmentInfQt1;
		return $this;
	}

	public function setTreatmentInfFare1($treatmentInfFare1) {
		$this->treatmentInfFare1 = $treatmentInfFare1;
		return $this;
	}

	public function setTreatmentInfTeeth1($treatmentInfTeeth1) {
		$this->treatmentInfTeeth1 = $treatmentInfTeeth1;
		return $this;
	}

	public function setTreatmentInf2($treatmentInf2) {
		$this->treatmentInf2 = $treatmentInf2;
		return $this;
	}

	public function setTreatmentInfQt2($treatmentInfQt2) {
		$this->treatmentInfQt2 = $treatmentInfQt2;
		return $this;
	}

	public function setTreatmentInfFare2($treatmentInfFare2) {
		$this->treatmentInfFare2 = $treatmentInfFare2;
		return $this;
	}

	public function setTreatmentInfTeeth2($treatmentInfTeeth2) {
		$this->treatmentInfTeeth2 = $treatmentInfTeeth2;
		return $this;
	}

	public function setTreatmentInf3($treatmentInf3) {
		$this->treatmentInf3 = $treatmentInf3;
		return $this;
	}

	public function setTreatmentInfQt3($treatmentInfQt3) {
		$this->treatmentInfQt3 = $treatmentInfQt3;
		return $this;
	}

	public function setTreatmentInfFare3($treatmentInfFare3) {
		$this->treatmentInfFare3 = $treatmentInfFare3;
		return $this;
	}

	public function setTreatmentInfTeeth3($treatmentInfTeeth3) {
		$this->treatmentInfTeeth3 = $treatmentInfTeeth3;
		return $this;
	}

	public function setTreatmentInf4($treatmentInf4) {
		$this->treatmentInf4 = $treatmentInf4;
		return $this;
	}

	public function setTreatmentInfQt4($treatmentInfQt4) {
		$this->treatmentInfQt4 = $treatmentInfQt4;
		return $this;
	}

	public function setTreatmentInfFare4($treatmentInfFare4) {
		$this->treatmentInfFare4 = $treatmentInfFare4;
		return $this;
	}

	public function setTreatmentInfTeeth4($treatmentInfTeeth4) {
		$this->treatmentInfTeeth4 = $treatmentInfTeeth4;
		return $this;
	}

	public function setTreatmentInf5($treatmentInf5) {
		$this->treatmentInf5 = $treatmentInf5;
		return $this;
	}

	public function setTreatmentInfQt5($treatmentInfQt5) {
		$this->treatmentInfQt5 = $treatmentInfQt5;
		return $this;
	}

	public function setTreatmentInfFare5($treatmentInfFare5) {
		$this->treatmentInfFare5 = $treatmentInfFare5;
		return $this;
	}

	public function setTreatmentInfTeeth5($treatmentInfTeeth5) {
		$this->treatmentInfTeeth5 = $treatmentInfTeeth5;
		return $this;
	}

	public function setTreatmentInf6($treatmentInf6) {
		$this->treatmentInf6 = $treatmentInf6;
		return $this;
	}

	public function setTreatmentInfQt6($treatmentInfQt6) {
		$this->treatmentInfQt6 = $treatmentInfQt6;
		return $this;
	}

	public function setTreatmentInfFare6($treatmentInfFare6) {
		$this->treatmentInfFare6 = $treatmentInfFare6;
		return $this;
	}

	public function setTreatmentInfTeeth6($treatmentInfTeeth6) {
		$this->treatmentInfTeeth6 = $treatmentInfTeeth6;
		return $this;
	}

	public function setTreatmentInf7($treatmentInf7) {
		$this->treatmentInf7 = $treatmentInf7;
		return $this;
	}

	public function setTreatmentInfQt7($treatmentInfQt7) {
		$this->treatmentInfQt7 = $treatmentInfQt7;
		return $this;
	}

	public function setTreatmentInfFare7($treatmentInfFare7) {
		$this->treatmentInfFare7 = $treatmentInfFare7;
		return $this;
	}

	public function setTreatmentInfTeeth7($treatmentInfTeeth7) {
		$this->treatmentInfTeeth7 = $treatmentInfTeeth7;
		return $this;
	}

	public function setTreatmentInf8($treatmentInf8) {
		$this->treatmentInf8 = $treatmentInf8;
		return $this;
	}

	public function setTreatmentInfQt8($treatmentInfQt8) {
		$this->treatmentInfQt8 = $treatmentInfQt8;
		return $this;
	}

	public function setTreatmentInfFare8($treatmentInfFare8) {
		$this->treatmentInfFare8 = $treatmentInfFare8;
		return $this;
	}

	public function setTreatmentInfTeeth8($treatmentInfTeeth8) {
		$this->treatmentInfTeeth8 = $treatmentInfTeeth8;
		return $this;
	}

	public function setTreatmentInf9($treatmentInf9) {
		$this->treatmentInf9 = $treatmentInf9;
		return $this;
	}

	public function setTreatmentInfQt9($treatmentInfQt9) {
		$this->treatmentInfQt9 = $treatmentInfQt9;
		return $this;
	}

	public function setTreatmentInfFare9($treatmentInfFare9) {
		$this->treatmentInfFare9 = $treatmentInfFare9;
		return $this;
	}

	public function setTreatmentInfTeeth9($treatmentInfTeeth9) {
		$this->treatmentInfTeeth9 = $treatmentInfTeeth9;
		return $this;
	}

	public function setTreatmentInf10($treatmentInf10) {
		$this->treatmentInf10 = $treatmentInf10;
		return $this;
	}

	public function setTreatmentInfQt10($treatmentInfQt10) {
		$this->treatmentInfQt10 = $treatmentInfQt10;
		return $this;
	}

	public function setTreatmentInfFare10($treatmentInfFare10) {
		$this->treatmentInfFare10 = $treatmentInfFare10;
		return $this;
	}

	public function setTreatmentInfTeeth10($treatmentInfTeeth10) {
		$this->treatmentInfTeeth10 = $treatmentInfTeeth10;
		return $this;
	}


	public function setTreatmentTotalFare($treatmentTotalFare) {
		$this->treatmentTotalFare = $treatmentTotalFare;
		return $this;
	}

	public function setDate($date) {
		$this->date = $date;
		return $this;
	}

	public function setNotes($notes) {
		$this->notes = $notes;
		return $this;
	}
}
