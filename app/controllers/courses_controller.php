<?php
class CoursesController extends AppController {
	var $name = 'Courses';
	var $paginate = array('limit' => 10, 'order' => array('Course.initial_date' => 'asc'));
	var $helpers = array('html', 'javascript', 'dateHelper');
	
	function index() {
		$this->set('courses', $this->Course->find('all'));
	}
	
	function add(){
		if (!empty($this->data)){
			if ($this->Course->save($this->data)){
				$this->Session->setFlash('El curso se ha guardado correctamente');
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
	function view($id = null) {
		$this->Course->id = $id;
		$this->set('course', $this->Course->read());
		$this->set('friendly_name', $this->Course->friendly_name());
	}
	
	function edit($id = null) {
		$this->Course->id = $id;
		if (empty($this->data)) {
			$this->data = $this->Course->read();
			$this->set('course', $this->data);
		} else {
			if ($this->Course->save($this->data)) {
				$this->Session->setFlash('El curso se ha actualizado correctamente.');
				$this->redirect(array('action' => 'view', $id));
			} else
				$this->set('course', $this->data);
		}
	}
	
	function copy($id) {
	  $course = $this->Course->find(array('id' => $id));
	  $this->Course->id = null;
	  $subjects_ids = array();
	  $new_course = array("Course" => array());
	  
    list($day,$month,$year) = split("-", $course["Course"]["initial_date"]);
    $new_course["Course"]["initial_date"] = "01-01-1900";

    list($day,$month,$year) = split("-", $course["Course"]["final_date"]);
    $new_course["Course"]["final_date"] = "31-01-1900";

	  $new_course["Course"]["name"] = $course["Course"]["name"]." (COPIA)";
	  
	  $this->Course->save($new_course);

	  foreach($course["Subject"] as $subject):
	    $this->Course->Subject->id = null;
	    $new_subject = array();
	    $new_subject["course_id"] = $this->Course->id;
	    $new_subject["code"] = $subject["code"];
	    $new_subject["level"] = $subject["level"];
	    $new_subject["type"] = $subject["type"];
	    $new_subject["name"] = $subject["name"];
	    $new_subject["acronym"] = $subject["acronym"];
	    $new_subject["semester"] = $subject["semester"];
	    $new_subject["credits_number"] = $subject["credits_number"];
	    $new_subject["coordinator_id"] = $subject["coordinator_id"];
	    $new_subject["practice_responsible_id"] = $subject["practice_responsible_id"];
	    $this->Course->Subject->save($new_subject);
	    
	    $groups = $this->Course->Subject->Group->find('all', array("conditions" => array("Group.subject_id =" => $subject["id"])));
	    foreach($groups as $group):
	      $this->Course->Subject->Group->id = null;
	      $new_group = array();
	      $new_group["subject_id"] = $this->Course->Subject->id;
	      $new_group["name"] = $group["Group"]["name"];
	      $new_group["type"] = $group["Group"]["type"];
	      $new_group["capacity"] = $group["Group"]["capacity"];
	      $new_group["notes"] = $group["Group"]["notes"];
        
        $this->Course->Subject->Group->save($new_group);
	    endforeach;
	    
	    $activities = $this->Course->Subject->Activity->find('all', array("conditions" => array("Activity.subject_id =" => $subject["id"])));
	    
	    foreach($activities as $activity):
	      $this->Course->Subject->Activity->id = null;
	      $new_activity = array();
	      $new_activity["subject_id"] = $this->Course->Subject->id;
	      $new_activity["type"] = $activity["Activity"]["type"];
	      $new_activity["name"] = $activity["Activity"]["name"];
	      $new_activity["notes"] = $activity["Activity"]["notes"];
	      $new_activity["duration"] = $activity["Activity"]["duration"];
	      
	      $this->Course->Subject->Activity->save($new_activity);
	    endforeach;
	  endforeach;
	  
	  $this->Session->setFlash('El curso se ha copiado correctamente.');
	  $this->redirect(array('action' => 'index'));
	}
	
	function delete($id) {
		$this->Course->delete($id);
		$this->Session->setFlash('El curso ha sido eliminado correctamente');
		$this->redirect(array('action' => 'index'));
	}
	
	function stats_by_teacher($course_id = null) {
	  $this->Course->id = $course_id;
		$this->set('course', $this->Course->read());
		$this->set('friendly_name', $this->Course->friendly_name());
		$date = Date('Y-m-d');

	  $teachers = $this->Course->query("SELECT Teacher.*, IFNULL(teorical.total, 0) AS teorical, IFNULL(practice.total, 0) AS practice, IFNULL(others.total, 0) AS others FROM users Teacher LEFT JOIN (SELECT teacher_id, SUM(IFNULL(duration,0)) as total FROM (SELECT ar1.duration, ar1.teacher_id AS teacher_id, IF(activities.type IN ('Clase magistral', 'Seminario'), 'T', IF(activities.type IN ('Tutoría', 'Evaluación', 'Taller/trabajo en grupo'), 'O', 'P')) AS type, subjects.course_id FROM attendance_registers ar1 INNER JOIN activities ON ar1.activity_id = activities.id INNER JOIN subjects ON subjects.id = activities.subject_id WHERE DATE_FORMAT(ar1.initial_hour, '%Y-%m-%d') <= '{$date}' UNION ALL SELECT ar2.duration, ar2.teacher_2_id AS teacher_id, IF(activities2.type IN ('Clase magistral', 'Seminario'), 'T', IF(activities2.type IN ('Tutoría', 'Evaluación', 'Taller/trabajo en grupo'), 'O', 'P')) AS type, subjects2.course_id FROM attendance_registers ar2 INNER JOIN activities activities2 ON ar2.activity_id = activities2.id INNER JOIN subjects subjects2 ON subjects2.id = activities2.subject_id WHERE DATE_FORMAT(ar2.initial_hour, '%Y-%m-%d') <= '{$date}') teacher_stats WHERE type = 'T' AND course_id = {$course_id} GROUP BY teacher_id) teorical ON teorical.teacher_id = Teacher.id LEFT JOIN (SELECT teacher_id, SUM(IFNULL(duration,0)) as total FROM (SELECT ar1.duration, ar1.teacher_id AS teacher_id, IF(activities.type IN ('Clase magistral', 'Seminario'), 'T', IF(activities.type IN ('Tutoría', 'Evaluación', 'Taller/trabajo en grupo'), 'O', 'P')) AS type, subjects.course_id FROM attendance_registers ar1 INNER JOIN activities ON ar1.activity_id = activities.id INNER JOIN subjects ON subjects.id = activities.subject_id WHERE DATE_FORMAT(ar1.initial_hour, '%Y-%m-%d') <= '{$date}' UNION ALL SELECT ar2.duration, ar2.teacher_2_id AS teacher_id, IF(activities2.type IN ('Clase magistral', 'Seminario'), 'T', IF(activities2.type IN ('Tutoría', 'Evaluación', 'Taller/trabajo en grupo'), 'O', 'P')) AS type, subjects2.course_id FROM attendance_registers ar2 INNER JOIN activities activities2 ON ar2.activity_id = activities2.id INNER JOIN subjects subjects2 ON subjects2.id = activities2.subject_id WHERE DATE_FORMAT(ar2.initial_hour, '%Y-%m-%d') <= '{$date}') teacher_stats WHERE type = 'P' AND course_id = {$course_id} GROUP BY teacher_id) practice ON practice.teacher_id = Teacher.id LEFT JOIN (SELECT teacher_id, SUM(IFNULL(duration,0)) as total FROM (SELECT ar1.duration, ar1.teacher_id AS teacher_id, IF(activities.type IN ('Clase magistral', 'Seminario'), 'T', IF(activities.type IN ('Tutoría', 'Evaluación', 'Taller/trabajo en grupo'), 'O', 'P')) AS type, subjects.course_id FROM attendance_registers ar1 INNER JOIN activities ON ar1.activity_id = activities.id INNER JOIN subjects ON subjects.id = activities.subject_id WHERE DATE_FORMAT(ar1.initial_hour, '%Y-%m-%d') <= '{$date}' UNION ALL SELECT ar2.duration, ar2.teacher_2_id AS teacher_id, IF(activities2.type IN ('Clase magistral', 'Seminario'), 'T', IF(activities2.type IN ('Tutoría', 'Evaluación', 'Taller/trabajo en grupo'), 'O', 'P')) AS type, subjects2.course_id FROM attendance_registers ar2 INNER JOIN activities activities2 ON ar2.activity_id = activities2.id INNER JOIN subjects subjects2 ON subjects2.id = activities2.subject_id WHERE DATE_FORMAT(ar2.initial_hour, '%Y-%m-%d') <= '{$date}') teacher_stats WHERE type = 'O' AND course_id = {$course_id} GROUP BY teacher_id) others ON others.teacher_id = Teacher.id WHERE Teacher.type = 'Profesor' OR (Teacher.id IN (SELECT DISTINCT teacher_id FROM events)) ORDER BY Teacher.last_name, Teacher.first_name");

		$this->set('teachers', $teachers);
	}
	
	function stats_by_subject($course_id = null){
	  $this->Course->id = $course_id;
		$this->set('course', $this->Course->read());
		$this->set('friendly_name', $this->Course->friendly_name());
  		
	  $subjects = $this->Course->Subject->query("SELECT subjects.id, subjects.code, subjects.name, SUM(activities.expected_duration) AS expected_hours, SUM(activities.programmed_duration) AS programmed_hours, SUM(activities.registered_duration) AS registered_hours, IFNULL(su.total,0) AS students FROM subjects LEFT JOIN (SELECT subjects_users.subject_id, IFNULL(count(distinct subjects_users.user_id), 0) as total FROM subjects_users INNER JOIN activities ON activities.subject_id = subjects_users.subject_id GROUP BY subjects_users.subject_id) su ON su.subject_id = subjects.id INNER JOIN (SELECT Activity.id, Activity.subject_id, Activity.duration AS expected_duration, SUM(IFNULL(Event.duration, 0)) / `Group`.total AS programmed_duration, IFNULL(SUM(AttendanceRegister.duration), 0) / `Group`.total AS registered_duration FROM activities Activity LEFT JOIN events Event ON Event.activity_id = Activity.id LEFT JOIN (SELECT `groups`.subject_id, `groups`.type, count(id) as total FROM `groups` where `groups`.name NOT LIKE '%no me presento%' GROUP BY `groups`.subject_id, `groups`.type) `Group` ON `Group`.subject_id = Activity.subject_id AND `Group`.type = Activity.type LEFT JOIN (SELECT activity_id, event_id, SUM(duration) AS duration FROM attendance_registers GROUP BY activity_id, event_id) AttendanceRegister ON AttendanceRegister.activity_id = Activity.id AND AttendanceRegister.event_id = Event.id GROUP BY Activity.id) activities ON activities.subject_id = subjects.id WHERE subjects.course_id = {$course_id} GROUP BY subjects.id ORDER BY subjects.code ASC");
	  
	  $this->set('subjects', $subjects);
	}
	
	function export_stats_by_subject($course_id = null) {
	  $date = Date('Y-m-d');
	  
	  $subjects = $this->Course->Subject->query("SELECT subjects.id, subjects.code, subjects.name, SUM(activities.expected_duration) AS expected_hours, SUM(activities.programmed_duration) AS programmed_hours, SUM(activities.registered_duration) AS registered_hours, IFNULL(su.total,0) AS students FROM subjects LEFT JOIN (SELECT subjects_users.subject_id, IFNULL(count(distinct subjects_users.user_id), 0) as total FROM subjects_users INNER JOIN activities ON activities.subject_id = subjects_users.subject_id GROUP BY subjects_users.subject_id) su ON su.subject_id = subjects.id INNER JOIN (SELECT Activity.id, Activity.subject_id, Activity.duration AS expected_duration, SUM(IFNULL(Event.duration, 0)) / `Group`.total AS programmed_duration, IFNULL(SUM(AttendanceRegister.duration), 0) / `Group`.total AS registered_duration FROM activities Activity LEFT JOIN events Event ON Event.activity_id = Activity.id LEFT JOIN (SELECT `groups`.subject_id, `groups`.type, count(id) as total FROM `groups` where `groups`.name NOT LIKE '%no me presento%' GROUP BY `groups`.subject_id, `groups`.type) `Group` ON `Group`.subject_id = Activity.subject_id AND `Group`.type = Activity.type LEFT JOIN (SELECT activity_id, event_id, SUM(duration) AS duration FROM attendance_registers GROUP BY activity_id, event_id) AttendanceRegister ON AttendanceRegister.activity_id = Activity.id AND AttendanceRegister.event_id = Event.id GROUP BY Activity.id) activities ON activities.subject_id = subjects.id WHERE subjects.course_id = {$course_id} GROUP BY subjects.id ORDER BY subjects.code ASC");
	  $response = "Código;Nombre;Nº de matriculados;Horas planificadas;Horas programadas;Horas registradas\n";
	  
	  foreach($subjects as $subject):
	    $expected = str_replace('.', ',', $subject[0]['expected_hours']);
	    $programmed = str_replace('.', ',', $subject[0]['programmed_hours']);
	    $registered = str_replace('.', ',', $subject[0]['registered_hours']);
      $response .= "{$subject['subjects']['code']}";
      $response .= ";\"{$subject['subjects']['name']}\"";
      $response .= ";{$subject[0]['students']}";
      $response .= ";{$expected}";
      $response .= ";{$programmed}";
      $response .= ";{$registered}";
      $response .= "\n";
	  endforeach;
	  
	  $this->set('response', $response);
	  $this->set('filename', 'Estadisticas_asignatura.csv');

	  $this->render('export_stats_by_subject', 'download');
	}
	
	function _authorize() {
		parent::_authorize();
		
		$administrator_actions = array('add', 'edit', 'delete');

		$this->set('section', 'courses');
		
		if ((array_search($this->params['action'], $administrator_actions) !== false) && ($this->Auth->user('type') != "Administrador") && ($auth->user('type') != "Administrativo"))
			return false;
	
		return true;
	}
}
?>