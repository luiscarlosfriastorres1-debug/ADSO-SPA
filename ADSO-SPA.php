<?php
$empleados = [];
$op_activas = true;
$op_activas_register = true;
$i = 0;
function registrarEmpleado($empleados){
    $nombre = readline("Ingrese el nombre del empleado: ");
    $cargo = readline("Ingrese el cargo del empleado: ");

    $empleados[] = [
		"id" => count($empleados) + 1,
        "nombre" => $nombre,
        "cargo" => $cargo
    ];

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

			while (true){
				
				$op_register_empleado = readline("¿ Desea registrar empleado ?  s/n: ");
				
				if ($op_register_empleado == "s" || $op_register_empleado == "S"){

					$empleados = registrarEmpleado($empleados);
				
				}
				
				else if($op_register_empleado == "n" || $op_register_empleado == "N"){
				
					break;
				
				}
				
				else{
				
					echo "Opcion invalida";
				
				}


			}


			break;
		case 2:
		
			foreach($empleados as $emple){
				echo $emple["id"] . " " . "nombre: ". $emple["nombre"] . " cargo: " .$emple["cargo"] ."\n";
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
