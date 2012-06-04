<?php
/**
 * User model
 *
 * @version 2012-06-04
 */
class User extends AppModel {
	/**
	 * PHP4 compatibility
	 */
	var $name = 'User';

	/**
	 * HABTM relationships
	 */
	var $hasAndBelongsToMany = array(
		'Subject' => array('unique' => false, 'order' => 'Subject.level ASC, Subject.name ASC')
	);

	/**
	 * hasMany relationships
	 */
	var $hasMany = array(
		'Registration' => array('foreignKey' => 'student_id')
	);

	/**
	 * Validation rules
	 */
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
		return $this->query("SELECT events.* FROM events WHERE activity_id = {$activity_id} AND group_id = {$group_id} AND teacher_id = {$user_id}") > 0;
	}

	/**
	 * Returns the number of teaching hours
	 *
	 * @param integer $teacher ID of a teacher
	 * @param integer $course ID of a course
	 * @param string $type Type of the teaching activity
	 * @return float Number of hours teached
	 * @version 2012-06-04
	 */
	function teachingHours($teacher, $course, $type = 'all') {
		$activityFilter = null;
		if ($type === 'theory') {
			$activityFilter = "AND activities.type IN ('Clase magistral', 'Seminario')";
		} elseif ($type === 'practice') {
			$activityFilter = "AND activities.type IN ('Práctica en aula', 'Práctica de problemas', 'Práctica de informática', 'Práctica de microscopía', 'Práctica de laboratorio', 'Práctica clínica', 'Práctica externa')";
		} else if ($type === 'other') {
			$activityFilter = "AND activities.type IN ('Tutoría', 'Evaluación', 'Taller/trabajo en grupo')";
		}

		return $this->query("
			SELECT SUM(IFNULL(AttendanceRegister.duration, 0)) as total
			FROM attendance_registers AttendanceRegister
			INNER JOIN activities ON activities.id = AttendanceRegister.activity_id
			INNER JOIN subjects ON subjects.id = activities.subject_id
			WHERE (AttendanceRegister.teacher_id = $teacher OR AttendanceRegister.teacher_2_id = $teacher)
			AND subjects.course_id = $course
			$activityFilter
		");
	}
}
?>
