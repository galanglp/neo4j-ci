<?php
class Ambil extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_workflowProcess($xml,$notasi){
		$jml = count($xml->WorkflowProcesses->WorkflowProcess);
		return $this->get_element($xml->WorkflowProcesses->WorkflowProcess,$jml,$notasi);
	}

	public function get_element($elemen,$jml,$notasi){
		switch ($notasi) {
			case "activity":
			return $this->get_act($elemen,$jml);
			break;
			case "dataObject":
			return $this->get_dataObject($elemen,$jml);
			break;
			case "flow":
			return $this->get_transisi($elemen,$jml);
			break;
			case "flowData":
			return $this->get_dataTransisi($elemen,$jml);
			break;
			default:
			"code to be executed if n is different from all labels";
		}
	}

	public function get_act($elemen,$jml){
		$activity = array();
		for ($i=0; $i < $jml; $i++) { 
			if(isset($elemen[$i]->Activities)){
				for ($j=0; $j < count( $elemen[$i]->Activities->Activity); $j++) { 
					$id = (string)$elemen[$i]->Activities->Activity[$j]['Id'];
					$name = (string)$elemen[$i]->Activities->Activity[$j]['Name'];
					if ($name == "" || isset($elemen[$i]->Activities->Activity[$j]->Event) || isset($elemen[$i]->Activities->Activity[$j]->Route)) {
						$activity[] = $this->gateway_event($elemen[$i]->Activities->Activity[$j]);
					}else{
						$activity[] = $this->artifact($elemen[$i]->Activities->Activity[$j]);
					}
				}
			}
		}
		return $activity;
	}

	public function artifact($elemen){
		$inputset = isset($elemen->InputSets) ? isset($elemen->InputSets->InputSet) ? $elemen->InputSets->InputSet->Input : null : null;
		if (isset($inputset)) {

			return  array(
				'Id' => (string) $elemen['Id'],
				'Name' => (string) $elemen['Name'],
				'ArtifactId' =>  (string) $elemen->InputSets->InputSet->Input['ArtifactId']
			);
		}else{
			return  array(
				'Id' => (string) $elemen['Id'],
				'Name' =>  (string) $elemen['Name']
			);
		}
	}

	public function gateway_event($elemen){
		if (isset($elemen->Event)) {
			if (isset($elemen->Event->StartEvent['Trigger'])) {
				return array(
				'Id' => (string) $elemen['Id'], 
				'Name' => 'start'
			);
			}elseif (isset($elemen->Event->EndEvent['Result'])) {
				return array(
				'Id' => (string) $elemen['Id'], 
				'Name' => 'end'
			);
			}
		}
		if (isset($elemen->Route)) {
			if ($elemen->Route['GatewayType'] == "Inclusive") {
				return array(
					'Id' => (string) $elemen['Id'], 
					'Name' => 'or'
				);
			}elseif ($elemen->Route['GatewayType'] == "Parallel") {
				return array(
					'Id' => (string) $elemen['Id'], 
					'Name' => 'and'
				);
			}elseif ($elemen->Route['MarkerVisible'] != null){
				return array(
					'Id' => (string) $elemen['Id'], 
					'Name' => 'xor'
				);
			}elseif ($elemen->Route['GatewayDirection'] != null) {
				return array(
					'Id' => (string) $elemen['Id'],
					'Name' => 'xor'
				);
			}else{
				return array(
					'Id' => (string) $elemen['Id'],
					'Name' => 'xor'
				);
			}
		}
	}

	public function get_dataObject($elemen,$jml){
		$DataObjects = array();
		for ($a=0; $a < $jml; $a++) { 
			if(isset($elemen[$a]->DataObjects)){
				for ($j=0; $j < count($elemen[$a]->DataObjects->DataObject); $j++) { 
					$DataObjects[] = array(
						'Id' => (string)$elemen[$a]->DataObjects->DataObject[$j]['Id'],
						'Name' => (string)$elemen[$a]->DataObjects->DataObject[$j]['Name']
					);
				}
			}
		}
		return $DataObjects;
	}

	public function get_transisi($elemen,$jml){
		$transisi = array();
		for ($a=0; $a < $jml; $a++) { 
			if(isset($elemen[$a]->Transitions)){
				for ($j=0; $j < count($elemen[$a]->Transitions->Transition); $j++) { 
					$transisi[] = array(
						'Id' => (string)$elemen[$a]->Transitions->Transition[$j]['Id'],
						'From' => (string)$elemen[$a]->Transitions->Transition[$j]['From'],
						'To' => (string)$elemen[$a]->Transitions->Transition[$j]['To']
					);
				}
			}
		}
		return $transisi;
	}

	public function get_dataTransisi($elemen,$jml){
		$dataTransisi = array();
		for ($a=0; $a < $jml; $a++) { 
			if(isset($elemen[$a]->DataAssociations)){
				for ($j=0; $j < count($elemen[$a]->DataAssociations->DataAssociation); $j++) { 
					$dataTransisi[] = array(
						'Id' => (string)$elemen[$a]->DataAssociations->DataAssociation[$j]['Id'],
						'From' => (string)$elemen[$a]->DataAssociations->DataAssociation[$j]['From'],
						'To' => (string)$elemen[$a]->DataAssociations->DataAssociation[$j]['To']
					);
				}
			}
		}
		return $dataTransisi;
	}

	public function get_dataStore($xml){
		$dataStore = array();
		if (isset($xml->DataStores)) {
			for ($i=0; $i < count($xml->DataStores->DataStore); $i++) { 
				$dataStore[] = array(
					'Id' => (string) $xml->DataStores->DataStore[$i]['Id'],
					'Name' => (string) $xml->DataStores->DataStore[$i]['Name']
				);
			}
		}

		return $dataStore;
	}

	public function get_messageFlow($xml){
		$messageFlow = array();
		if (isset($xml->MessageFlows)) {
			for ($i=0; $i < count( (array) $xml->MessageFlows->MessageFlow); $i++) { 
				$messageFlow[] = array(
					'Id' => (string) $xml->MessageFlows->MessageFlow[$i]['Id'],
					'Source' => (string) $xml->MessageFlows->MessageFlow[$i]['Source'],
					'Target' => (string) $xml->MessageFlows->MessageFlow[$i]['Target']
				);
			}
		}

		return $messageFlow;
	}

	public function get_association($xml){
		$association = array();
		if (isset($xml->Associations)) {
			for ($i=0; $i < count($xml->Associations->Association); $i++) { 
				$association[] = array(
					'Id' => (string) $xml->Associations->Association[$i]['Id'],
					'Source' => (string) $xml->Associations->Association[$i]['Source'],
					'Target' => (string) $xml->Associations->Association[$i]['Target']
				);
			}
		}

		return $association;
	}

	public function get_desk($xml){
		$penulis = (string) $xml->RedefinableHeader->Author;
		$versi = (string) $xml->RedefinableHeader->Version;
		$tgl_dibuat = (string) $xml->PackageHeader->Created;
		$tgl_modifikasi = (string) $xml->PackageHeader->ModificationDate;

		return array(
			'penulis' => $penulis,
			'versi' => $versi,
			'tgl_dibuat' => $tgl_dibuat,
			'tgl_modifikasi' => $tgl_modifikasi
		);
	}

}
?>