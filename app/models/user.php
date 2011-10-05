<?php
class User extends AppModel {
	var $name = 'User';
	var $hasAndBelongsToMany = array(
		'Subject' =>
			array(
					'className'				=> 'Subject',
					'joinTable'				=> 'subjects_users',
					'foreignKey'			=> 'user_id',
					'associationForeignKey'	=> 'subject_id',
					'unique'				=> false, 
					'order'					=> 'Subject.level ASC, Subject.name ASC'
				)
		);
	var $hasMany = array(
		'Registration' => array(
			'foreignKey' => 'student_id'
			)
		);
	var $validate = array(
		'username' => array(
				'isUnique' => array(
					'rule' => 'isUnique', 
					'message' => 'Ya existe un usuario con el mismo correo electrónico.'
				)
			),
			'vat_number' => array(
				'rule' => 'isUnique', 
				'message' => 'Ya existe un usuario con el mismo DNI.'
			), 
			'password' => array(
				'rule' => array('minLength', '6'),
				'message' => 'Debe tener entre 5 y 10 caracteres'
			),
			'type' => array(
				'rule' => 'notEmpty',
				'message' => 'Debe especificar el tipo de usuario'
			),
			'first_name' => array(
				'rule' => 'notEmpty',
				'message' => 'Debe especificar el nombre de pila'
			)
		);
	
	function can_send_alerts($user_id, $activity_id, $group_id) {
	  $events = $this->query("SELECT events.* FROM events WHERE activity_id = {$activity_id} AND group_id = {$group_id} AND teacher_id = {$user_id}");
	  if (count($events) > 0)
	    return true;
	  else
	    return false;
	}
}
?>