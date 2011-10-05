<?php

class CourseBehavior extends ModelBehavior {
	function friendly_name(&$Model){
		return "{$Model->data[$Model->alias]['name']} ({$Model->data[$Model->alias]['initial_date']} - {$Model->data[$Model->alias]['final_date']})";
	}
}
?>