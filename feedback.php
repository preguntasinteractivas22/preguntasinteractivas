<?php
session_start();
require('panel/config.php');
use Jajo\JSONDB;

if( isset ( $_SESSION['cantidadpreguntas'] ) ) {

	$cantidadpreguntas = intval($_SESSION['cantidadpreguntas']);

	$json_db = new JSONDB(__DIR__);

	$i = 0;

	$resultado = array(
	'tipo1' => 0,
	'tipo2' => 0,
	'tipo3' => 0);

	$contador = 1;

	while($cantidadpreguntas > $contador) {
		++$contador;
		++$i;
		
		$puntaje1 = 0;
		$puntaje2 = 0;
		$puntaje3 = 0;
		$checksum = 1;
		$checksum_valid = false;
		
		$puntajepregunta = 0;
		
		$estadisticapreguntas = array();
		
		if ( isset( $_POST['preg' . $i . '_checksum'] ) and isset ( $_POST['preg' . $i . '_tipo1'] ) and isset ( $_POST['preg' . $i . '_tipo2'] ) and isset ( $_POST['preg' . $i . '_tipo3'] ) ) {
			
			$puntaje1 = intval($_POST['preg' . $i . '_tipo1']);
			$puntaje2 = intval($_POST['preg' . $i . '_tipo2']);
			$puntaje3 = intval($_POST['preg' . $i . '_tipo3']);
			$checksum = htmlspecialchars(strip_tags($_POST['preg' . $i . '_checksum']));
			
			$puntajepregunta = $puntaje1 + $puntaje2 + $puntaje3;
			
			if($puntaje1<0 or $puntaje1>6 or $puntaje2<0 or $puntaje2>6 or $puntaje3<0 or $puntaje3>6){
				die();
			}
			
			if ( $puntajepregunta > 0 ) {
			
				$resultado['tipo1'] = $puntaje1;
				$resultado['tipo2'] = $puntaje2;
				$resultado['tipo3'] = $puntaje3;
				
				$estadisticapreguntas = $json_db->select('*')
				->from('panel/app/json/estadistica-pregunta.json')
				->where( [ 'id' => $checksum ])
				->get();
		
				unset($estadisticapreguntas->file);

				if (!empty($estadisticapreguntas)) {
					
					$estadisticapreguntas[0]['tipo1'] += $puntaje1;
					$estadisticapreguntas[0]['tipo2'] += $puntaje2;
					$estadisticapreguntas[0]['tipo3'] += $puntaje3;
					$estadisticapreguntas[0]['hits'] += 1;
					
				$datos = $json_db->update( ['hits' => $estadisticapreguntas[0]['hits'],'tipo1' => $estadisticapreguntas[0]['tipo1'], 'tipo2' => $estadisticapreguntas[0]['tipo2'], 'tipo3' => $estadisticapreguntas[0]['tipo3']] )
				->from('panel/app/json/estadistica-pregunta.json')
				->where([ 'id' => $checksum ])
				->trigger();				
					
				}else{
					
					$checksum_valid = $json_db->select('id, pregunta, respuestas')
					->from('panel/app/json/preguntas.json')
					->where([ 'id' => $checksum ])
					->get();
					
					unset($checksum_valid->file);
					
					if(!empty($checksum_valid)){
						$json_db->insert('panel/app/json/estadistica-pregunta.json', 
							[ 
								'id' => $checksum,
								'tipo1' => $puntaje1,
								'tipo2' => $puntaje2,
								'tipo3' => $puntaje3,
								'hits' => 1
							]
						);
				
					}else{
						die();
					}
				}
			}
		}
	}
	
	if( ( $resultado['tipo1'] + $resultado['tipo2'] + $resultado['tipo3'] ) > 0 ){
	
	$estadisticatipo = $json_db->select('*')
		->from('panel/app/json/estadistica-tipo.json')
		->where(['id' => 1])
		->get();
	
	unset($estadisticatipo->file);

	if (empty($estadisticatipo)){
		$json_db->insert('panel/app/json/estadistica-tipo.json', 
							[ 
								'id' => 1,
								'tipo1' => $resultado['tipo1'],
								'tipo2' => $resultado['tipo2'],
								'tipo3' => $resultado['tipo3'],
								'hits' => 1
							]
		);
		
	}else{
		
		$estadisticatipo[0]['tipo1'] += $resultado['tipo1'];
		$estadisticatipo[0]['tipo2'] += $resultado['tipo2'];
		$estadisticatipo[0]['tipo3'] += $resultado['tipo3'];
		$estadisticatipo[0]['hits'] += 1;
		
		$datos = $json_db->update( ['hits' => $estadisticatipo[0]['hits'], 'tipo1' => $estadisticatipo[0]['tipo1'], 'tipo2' => $estadisticatipo[0]['tipo2'], 'tipo3' => $estadisticatipo[0]['tipo3']])
				->from('panel/app/json/estadistica-tipo.json')
				->where([ 'id' => 1 ])
				->trigger();
	
	}
}
}
	


?>