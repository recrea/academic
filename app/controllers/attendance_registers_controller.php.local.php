<?php
	class AttendanceRegistersController extends AppController {
		var $name = 'AttendanceRegisters';
		var $paginate = array('limit' => 10, 'order' => array('AttendanceRegister.initial_hour' => 'desc'));
		var $helpers = array('Ajax', 'Barcode');
		
		function index($teacher_id = -1, $activity_id = -1, $date = -1) {
			if (!empty($this->data)){
				$conditions = $this->_get_search_conditions($this->data['AttendanceRegister']['activity_id'], $this->data['AttendanceRegister']['teacher_id'], $this->data['AttendanceRegister']['date']);
        
				$registers = $this->paginate('AttendanceRegister', array($conditions));
				
			} else if ( ($teacher_id != -1) || ($activity_id != -1) || ($date != -1) ) {
			  if ($activity_id == -1)
			    $activity_id = null;
			  
			  if ($teacher_id == -1)
			    $teacher_id = null;
			  
			  if ($date == -1)
			    $date = null;
			    
			  $conditions = $this->_get_search_conditions($activity_id, $teacher_id, $date);  
			  $registers = $this->paginate('AttendanceRegister', array($conditions));
			}
			else{
				$registers = $this->paginate('AttendanceRegister', array('AttendanceRegister.duration > 0'));
			}
			
			$this->set('registers', $registers);
		}
		
		function _get_search_conditions($activity_id, $teacher_id, $date){
		  $conditions = "AttendanceRegister.duration > 0";
			if ($activity_id != null){
				$activity = $this->AttendanceRegister->Activity->findById($activity_id);
				$this->set('activity', $activity);
				$conditions .= " AND AttendanceRegister.activity_id = {$activity_id}";
			}
			
			if ($teacher_id != null){
				$teacher = $this->AttendanceRegister->Teacher->findById($teacher_id);
				$this->set('teacher', $teacher);
				$conditions .= " AND AttendanceRegister.teacher_id = {$teacher_id}";
			}
				
			if ($date != null) {
				$date = $this->_parse_date($date, "-");
				$this->set('date', date_create($date));
				$conditions .= " AND DATE_FORMAT(AttendanceRegister.initial_hour, '%Y-%m-%d') = '{$date}'";
			}
			
			return $conditions;
		}
		
		function add(){
			if (!empty($this->data)){
				list($id) = sscanf($this->data['AttendanceRegister']['id'], "%d");
				if ($id != null) {
					$this->AttendanceRegister->id = $id;
					$ar = $this->AttendanceRegister->read();
					
					$this->data['AttendanceRegister']['initial_hour'] = $this->data['AttendanceRegister']['initial_hour']['hour'].":".$this->data['AttendanceRegister']['initial_hour']['minute'];
					$this->data['AttendanceRegister']['final_hour'] = $this->data['AttendanceRegister']['final_hour']['hour'].":".$this->data['AttendanceRegister']['final_hour']['minute'];
					
					if (!(isset($this->data['AttendanceRegister']['teacher_id'])))
            $this->data['AttendanceRegister']['teacher_id'] = $ar["Event"]["teacher_id"];
					
					if (isset($this->data['AttendanceRegister']['students'])){
						$students = array_unique(array_keys($this->data['AttendanceRegister']['students']));
						$this->data['Student']['Student'] = $students;
					}
					
					if ($this->AttendanceRegister->save($this->data)){
						$this->Session->setFlash('El registro de asistencia se ha creado correctamente.');
						$this->redirect(array('action' => 'index'));
					}
					else {
						$this->Session->setFlash('No se ha podido crear el registro de asistencia. Por favor, revise que ha introducido todos los datos correctamente.');
						$this->redirect(array('action' => 'index'));
					}
				} else {
					$this->Session->setFlash('No se puede crear un registro de asistencia sin especificar su código de barras.');
					$this->redirect(array('action' => 'index'));
				}
			}
		}
		
		function view($id){
			$this->AttendanceRegister->id = $id;
			$ar = $this->AttendanceRegister->read();
			$this->set('ar', $ar);
			$this->set('subject', $this->AttendanceRegister->Activity->Subject->findById($ar['Activity']['subject_id']));
		}
		
		function get_register_info($event_id = null){
			list($id) = sscanf($event_id, "%d");
			$ar = $this->AttendanceRegister->findById($id);
			$ar["AttendanceRegister"]["teacher_id"] = $ar["Event"]["teacher_id"];
			$teacher = $this->AttendanceRegister->Teacher->findById($ar["Event"]["teacher_id"]);
			$ar["Teacher"] = $teacher["Teacher"];
			
			if ($ar != null){
				$students = $this->AttendanceRegister->Student->query("SELECT Student.* FROM users Student INNER JOIN registrations Registration ON Registration.student_id = Student.id WHERE Registration.group_id = {$ar['Event']['group_id']} AND Registration.activity_id = {$ar['Event']['activity_id']} ORDER BY Student.last_name");

				$subject = $this->AttendanceRegister->Activity->Subject->findById($ar['Activity']['subject_id']);
			
				$this->set('ar', $ar);
				$this->set('students', $students);
				$this->set('subject', $subject);
			}
		}
		
		function edit($id = null){
			$this->AttendanceRegister->id = $id;
			if (!empty($this->data)){
				$this->data['AttendanceRegister']['id'] = $id;
				$this->data['AttendanceRegister']['initial_hour'] = $this->data['AttendanceRegister']['initial_hour']['hour'].":".$this->data['AttendanceRegister']['initial_hour']['minute'];
				$this->data['AttendanceRegister']['final_hour'] = $this->data['AttendanceRegister']['final_hour']['hour'].":".$this->data['AttendanceRegister']['final_hour']['minute'];
				
				if (isset($this->data['AttendanceRegister']['students'])){
					$students = array_unique(array_keys($this->data['AttendanceRegister']['students']));
					$this->data['Student']['Student'] = $students;
				}
				
				if ($this->AttendanceRegister->save($this->data)){
					$this->Session->setFlash('El registro de asistencia se ha creado correctamente.');
					$this->redirect(array('action' => 'view', $id));
				}
				else {
					$this->Session->setFlash('No se ha podido crear el registro de asistencia. Por favor, revise que ha introducido todos los datos correctamente.');
					$this->redirect(array('action' => 'view', $id));
				}
				
			} else {
				$this->data = $this->AttendanceRegister->read();
				$this->set('subject', $this->AttendanceRegister->Activity->Subject->findById($this->data['Activity']['subject_id']));
				$this->set('ar', $this->data);
			}
		}
		
		function print_attendance_file($event_id = null){
			$this->layout = 'print';
			if ($event_id != null) {
				$event = $this->AttendanceRegister->Event->findById($event_id);
				$students = $this->AttendanceRegister->Student->query("SELECT Student.* FROM users Student INNER JOIN registrations Registration ON Student.id = Registration.student_id WHERE Registration.activity_id = {$event['Event']['activity_id']} AND Registration.group_id = {$event['Event']['group_id']} ORDER BY Student.last_name");
				
				if ($event['AttendanceRegister']['id'] == null) {
					$ar = array('AttendanceRegister' => array(
						'event_id' => $event_id,
						'activity_id' => $event['Activity']['id'],
						'group_id' => $event['Group']['id'],
						'teacher_id' => $event['Teacher']['id'],
					));
					$this->AttendanceRegister->save($ar);
					$event['AttendanceRegister'] = $ar;
					$event['AttendanceRegister']['id'] = $this->AttendanceRegister->id;
				} else {
				  $this->AttendanceRegister->query("UPDATE attendance_registers SET teacher_id = {$event["Teacher"]["id"]} WHERE id = {$event['AttendanceRegister']['id']}");
				  
  				$this->AttendanceRegister->id = $event['AttendanceRegister']['id'];
  				$ar = $this->AttendanceRegister->read();
				}
				
				$this->set('event', $event);
				$this->set('students', $students);
				$this->set('subject', $this->AttendanceRegister->Event->Activity->Subject->findById($event['Activity']['subject_id']));
			}
		}
		
		function _authorize(){
			parent::_authorize();
			
			$private_actions = array("index", "add", "edit", "get_register_info");
			
			if (($this->Auth->user('type') != "Profesor") && ($this->Auth->user('type') != "Administrador") && ($this->Auth->user('type') != "Administrativo") && ($this->Auth->user('type') != "Becario"))
				return false;
			
			if (($this->Auth->user('type') != "Administrador") && ($this->Auth->user('type') != "Becario") && ($this->Auth->user('type') != "Administrativo") && (array_search($this->params['action'], $private_actions) !== false))
				return false;
				
			$this->set('section', 'attendance_registers');
			return true;
		}
	}
?>
