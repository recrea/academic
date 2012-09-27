<?php 
	if (!count($attendanceRegisters)) {
		echo "No existe ningún registro con el código especificado";
	}
	else {
		foreach ($attendanceRegisters as $register):	
			echo "{$register['AttendanceRegister']['id']}|{$register['AttendanceRegister']['id']}\n" ;
		endforeach;
	} 
?>