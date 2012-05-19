<?php
require_once('models/academic_model.php');

class Subject extends AcademicModel {
	var $name = "Subject";

	var $hasMany = array(
		'Group' => array(
			'className' => 'Group',
			'order' => array('Group.type ASC', 'Group.name ASC')
		),
		'Activity' => array(
			'order' => array('Activity.type ASC', 'Activity.name ASC')
		)
	);

	var $belongsTo = array(
		'Course' => array(
			'className' => 'Course'
		),
		'Coordinator' => array(
			'className' => 'User', 
			'conditions' => array("(Coordinator.type = 'Profesor' OR Coordinator.type = 'Administrador')")
		),
		'Responsible' => array(
			'className' => 'User',
			'foreignKey' => 'practice_responsible_id',
			'conditions' => array("(Responsible.type = 'Profesor' OR Responsible.type = 'Administrador')")
		)
	);

	var $validate = array(
		'code' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe introducir el código de la asignatura (p.ej. 12587)'
			),
			'unique' => array(
				'rule' => array('codeMustBeUnique'),
				'on' => 'create',
				'message' => 'Ya existe una asignatura con este código en el curso'
			)
		),
		'level' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe introducir el nivel de la asignatura'
			)
		),
		'type' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe introducir el tipo de la asignatura'
			)
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe introducir el nombre de la asignatura (p.ej. Matemática)'
			)
		),
		'credits_number' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe introducir el número de créditos de la asignatura (p.ej. 5.5)'
			)
		),
		'acronym' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe introducir un acrónimo para esta asignatura'
			),
			'less_than_5_characters' => array(
				'rule' => array('between', 0, 5),
				'message' => 'El acrónimo debe tener menos de 5 caracteres'
			)
		),
		'coordinator_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'El coordinador de la asignatura no puede estar vacío'
			)
		),
		'practice_responsible_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'El responsable de prácticas de la asignatura no puede estar vacío'
			)
		)
	);

	/**
	 * Validates that a combination of code,course is unique
	 */
	function codeMustBeUnique($code){
		$subject = $this->data[$this->alias];
		return $this->find('count', array('conditions' => array(
			'Subject.code' => $code,
			'Subject.course_id' => $subject['course_id'],
		))) == 0;
	}
}
?>
