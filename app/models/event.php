<?php
require_once('models/academic_model.php');

class Event extends AcademicModel {
	var $name = "Event";
	var $hasOne = "AttendanceRegister";

	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group'
			),
		'Activity' => array(
			'className' => 'Activity'
			),
		'Classroom' => array(
			'className' => 'Classroom'
			),
		'Teacher' => array(
			'className' => 'User',
			'conditions' => array("(Teacher.type = 'Profesor' OR Teacher.type = 'Administrador')")
			),
		'Teacher_2' => array(
		  'className' => 'User',
		  'conditions' => array("(Teacher.type = 'Profesor' OR Teacher.type = 'Administrador')")
		  ),
		'Parent' => array(
			'className' => 'Event',
			'foreignKey' => 'parent_id'
			)
		);
	var $hasMany = array(
		'Events' => array(
				'className' => 'Event',
				'foreignKey' => 'parent_id'
			)
		);
	var $validate = array(
		'classroom_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe especificar un aula para este evento'
				)
			),
		'initial_hour' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe especificar una fecha de inicio para este evento'
				),
			'eventDontOverlap' => array(
				'rule' => array('eventDontOverlap')
				),
			'eventDurationDontExceedActivityDuration' => array(
				'rule' => array('eventDurationDontExceedActivityDuration')
				)
			),
		'final_hour' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe especificar una fecha de inicio para este evento'
				),
			),
		'teacher_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Debe especificar un profesor'
			)
		)
		);

	function eventDontOverlap($initial_hour){
		$initial_hour = $this->data['Event']['initial_hour'];
		$final_hour = $this->data['Event']['final_hour'];
		$classroom_id = $this->data['Event']['classroom_id'];
		$query = "SELECT Event.id FROM events Event WHERE ((Event.initial_hour <= '{$initial_hour}' AND Event.final_hour > '{$initial_hour}') OR (Event.initial_hour < '{$final_hour}' AND Event.final_hour >= '{$final_hour}') OR (Event.initial_hour >= '{$initial_hour}' AND Event.final_hour <= '{$final_hour}')) AND Event.classroom_id = {$classroom_id}";

		if ((isset($this->data['Event']['id'])) && ($this->data['Event']['id'] > 0))
			$query .= " AND Event.id <> {$this->data['Event']['id']}";

		$events_count = $this->query($query);
		if (count($events_count) > 0) {
			$this->id = $events_count[0]['Event']['id'];
			return false;
		}
		else
			return (count($events_count) == 0);
	}

	function eventDurationDontExceedActivityDuration($initial_hour){
		$activity = $this->Activity->find('first', array('conditions' => array('Activity.id' => $this->data['Event']['activity_id'])));
		$query = "SELECT activity_id, group_id, sum(duration) as scheduled from events Event WHERE activity_id = {$activity['Activity']['id']} AND group_id = {$this->data['Event']['group_id']}";

		if (isset($this->data['Event']['id']))
			$query .= " AND Event.id <> {$this->data['Event']['id']}";

		$query .= " group by activity_id, group_id";

		$duration = $this->query($query);

		if ((isset($duration[0])) && (isset($duration[0][0]['scheduled'])) && ($duration[0][0]['scheduled'] != null) )
			$duration = $duration[0][0]['scheduled'];
		else
			$duration = 0;

		if ( ($duration + $this->data['Event']['duration']) > $activity['Activity']['duration']){
			$this->id = -1;
			return false;
		}
		else
			return true;
	}

	function beforeValidate(){
		if (!empty($this->data['Event']['initial_hour'])) {
			$initial_hour = date_create($this->data['Event']['initial_hour']);
			$this->data['Event']['initial_hour'] = $initial_hour->format('Y-m-d H:i:s');
		}
		if (!empty($this->data['Event']['final_hour'])){
			$final_hour = date_create($this->data['Event']['final_hour']);
			$this->data['Event']['final_hour'] = $final_hour->format('Y-m-d H:i:s');
		}

		if ((!empty($this->data['Event']['initial_hour'])) && (!empty($this->data['Event']['final_hour'])))
			$this->data['Event']['duration'] = $this->_get_event_duration($initial_hour, $final_hour);

		return true;
	}

	function _get_event_duration($initial_hour, $final_hour) {
		// Hour, minute, second, month, day, year
		$initial_timestamp = $this->_get_timestamp($initial_hour);
		$final_timestamp = $this->_get_timestamp($final_hour);
		return ($final_timestamp - $initial_timestamp) / 3600.0;
	}

	function _get_timestamp($date){
		$date_components = split("-", $date->format('Y-m-d-H-i-s'));
		return mktime($date_components[3],$date_components[4],$date_components[5], $date_components[1], $date_components[2], $date_components[0]);
	}

	function findRegisteredStudents($id = null) {
		$event = $this->find('first', array('conditions' => array('Event.id' => $id), 'recursive' => -1));
		return $this->AttendanceRegister->Student->find('all', array(
			'joins' => array(
				array(
					'table' => 'registrations',
					'alias' => 'Registration',
					'type' => 'INNER',
					'conditions' => array('Registration.student_id = Student.id'),
				),
			),
			'conditions' => array(
				'Registration.group_id' => $event['Event']['group_id'],
				'Registration.activity_id' => $event['Event']['activity_id'],
			),
			'fields' => array('Student.id', 'Student.first_name', 'Student.last_name'),
			'recursive' => -1,
			'order' => array('Student.last_name', 'Student.first_name'),
		));
	}

	/**
	 * Finds all events on a given date
	 *
	 * @param date Date when events take place
	 * @return Array of events
	 * @since 2013-03-10
	 */
	function findAllByDate($date = '') {
		if (empty($date)) {
			return array();
		}

		$this->Behaviors->attach('Containable');

		$this->unbindModel(array(
			'belongsTo' => array('Activity')
		));
		$this->bindModel(array(
			'hasOne' => array(
				'Activity' => array(
					'foreignKey' => false,
					'conditions' => array('Activity.id = Event.activity_id')
				),
				'Subject' => array(
					'foreignKey' => false,
					'conditions' => array('Subject.id = Activity.subject_id')
				)
			)
		));
		return $this->find('all', array(
			'fields' => array(
				'Event.initial_hour', 'Event.final_hour',
				'Teacher.first_name', 'Teacher.last_name',
				'Classroom.name', 'Subject.name'
			),
			'contain' => array('Teacher', 'Classroom', 'Activity', 'Subject'),
			'conditions' => array('Event.initial_hour >= ' => $date . ' 00:00:00', 'Event.final_hour <=' => $date . ' 23:59:59'),
			'order' => array('Event.initial_hour'),
		));
	}
}
?>
