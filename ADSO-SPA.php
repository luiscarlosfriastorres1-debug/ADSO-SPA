<?php
$empleados = [];
$op_activas = true;

function registrarEmpleado(){
	$nombre = readline("Ingrese el nombre del empleado: ");
	$empleados[] = $nombre;

	$cargo = readline("Ingrese el cargo del empleado: ");
	$empleados[] = $cargo;
	return $empleados;
}

while($op_activas){
	
	echo "====== Bienvenido ADSO-SPA =======\n";
	echo " \n";
	echo "| 1. Registrar empleado           |\n";
	echo "| 2. Registrar cita               |\n";
	echo "| 3. Total facturado por empleado |\n";
	echo "| 4. Servicio más solicitado      |\n";
	echo "| 5. Agenda de un día             |\n";
	echo "| 6. Detección de conflictos      |\n";
	echo "| 7. Liquidacion de comisiones    |\n";
	echo "| 8. Salir                        |\n";
	echo "\n";
	$opcion = readline("Seleccione una opcion: ");
	echo "\n";

	switch($opcion){
		case 1:

			$empleados = registrarEmpleado();
			break;
		case 2:
			echo "hola";
			echo count($empleados);
			foreach($empleados as $emple){
				echo $emple;
			}
			break;
		case 3:


			break;
		case 4:


			break;
		case 5:


			break;
		case 6:


			break;
		case 7:


			break;
		case 8:

			$op_activas = false;

			break;

		default:
			echo "Opcion no valida\n";
			break;
	}
}




?>





