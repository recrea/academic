<?php
class ActivityHelperHelper extends AppHelper {
	function getActivityClassName($type){
	switch($type){
			case "Clase magistral":
				return "clase_magistral";
			case "Seminario":
				return "seminario";
			case "Taller/trabajo en grupo":
				return "taller_trabajo";
			case "Práctica en aula":
				return "practica_aula";
			case "Práctica de problemas":
				return "practica_problemas";
			case "Práctica de informática":
				return "practica_informatica";
			case "Práctica de microscopía":
				return "practica_microscopia";
			case "Práctica de laboratorio":
				return "practica_laboratorio";
			case "Práctica clínica":
				return "practica_clinica";
			case "Práctica externa":
				return "practica_externa";
			case "Tutoría":
				return "tutoria";
			case "Evaluación":
				return "evaluacion";
			case "Otra presencial":
				return "otra_presencial";
		}
	}
}
?>