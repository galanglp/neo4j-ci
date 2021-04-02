<?php
class Ambil_vdx extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_shapes($xml, $id){
		$shapes = $xml->Pages->Page->Shapes->Shape;
		$jml = count( $shapes);
		for ($i=0; $i < $jml; $i++) { 

			if($id == $shapes[$i]['ID']){
				return $this->get_NameU($xml,(string)$shapes[$i]['Master']);
			}

			if($shapes[$i]->Shapes != null){
				for ($j=0; $j < count( (array) $shapes[$i]->Shapes->Shape); $j++) {
					if ($id == $shapes[$i]->Shapes->Shape[$j]['ID']) {
						return $this->get_NameU($xml,(string)$shapes[$i]['Master']);
					}
					if (!empty($shapes[$i]->Shapes->Shape[$j]->Shapes)) {
						for ($k=0; $k < count( (array)  $shapes[$i]->Shapes->Shape[$j]->Shapes->Shape); $k++) { 
							if ($id == $shapes[$i]->Shapes->Shape[$j]->Shapes->Shape[$k]['ID']) {
								return $this->get_NameU($xml,(string)$shapes[$i]['Master']);
							}
						}
					}
				}
			}
		}
	}

	public function get_text_act($xml,$id){
		$shapes = $xml->Pages->Page->Shapes->Shape;
		$jml = count( $shapes);
		for ($i=0; $i < $jml; $i++) { 
			if($id == $shapes[$i]['ID']){
				return substr((string)$shapes[$i]->Text, 0, -1);
			}
		}
	}

	public function get_NameU($xml,$id){
		$master = $xml->Masters->Master;
		$jml = count( $master);

		for ($i=0; $i < $jml; $i++) { 
			if ($master[$i]['ID'] == $id) {
				return (string) $master[$i]['Name'];
			}
		}
	}

	public function get_connects($xml){
		$connects = $xml->Pages->Page->Connects->Connect;
		$jml = count( $connects);
		$connect;
		$from;
		$to;
		$tipe;

		for ($i=0; $i < $jml; $i++) { 
			if ((string)$connects[$i]['FromCell'] == "BeginX") {
				$from = (string)$connects[$i]['ToSheet'];
			}else{
				$to = (string)$connects[$i]['ToSheet'];
			}
			$tipe = (string)$connects[$i]['FromSheet'];
			if ($i%2!=0) {
				$connect[] = array(
				'From' => $from,
				'To' => $to,
				'Tipe' => $tipe,
			);
			}
		}
		return $connect;
	}

}
?>