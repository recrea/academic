<?php
require_once('models/academic_model.php');

class Activity extends AcademicModel {
	var $name = "Activity";
	var $belongsTo = 'Subject';
	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Debe especificar un nombre para la actividad'
			),
		'type' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'Debe especificar un tipo para la actividad' 
			),
		'duration' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Debe especificar una duración para la actividad'
				),
			'isNumeric' => array(
				'rule' => 'numeric',
				'message' => 'La duración debe ser un número (p.ej 10)'
				),
			'greter_than_0' => array(
				'rule' => array('comparison', ">", 0),
				'message' => 'La duración debe ser mayor que 0'
				)
			)
		);

	function _exists($id){
		$activity = $this->findById($id);
		
		return ($activity != null);
	}
}