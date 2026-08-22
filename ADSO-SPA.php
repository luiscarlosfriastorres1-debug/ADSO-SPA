<?php


// Listas y variables de mi proyecto


$empleados = [];
$citas = [];
$dias_de_la_semana = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];


$op_activas = true;
$op_activas_register = true;
$i = 0;

$servicios = [
    ["nombre" => "Limpieza facial",           "precio" => 80000,  "duracion" => 2],
    ["nombre" => "Manicure",                  "precio" => 35000,  "duracion" => 1],
    ["nombre" => "Pedicure",                  "precio" => 40000,  "duracion" => 1],
    ["nombre" => "Masaje relajante",          "precio" => 90000,  "duracion" => 1],
    ["nombre" => "Masaje descontracturante",  "precio" => 100000, "duracion" => 1],
    ["nombre" => "Exfoliación corporal",      "precio" => 60000,  "duracion" => 1],
    ["nombre" => "Tratamiento antiedad",      "precio" => 120000, "duracion" => 2],
];



// Funciones de mi proyecto


function registrarEmpleado($empleados){
    $nombre = readline("Ingrese el nombre del empleado: ");
	
	// Valido para que el nombre no este vacio
	while ($nombre == "") {
	
		$nombre = readline("No puede estar vacio. Ingrese el nombre del empleado: ");
	
	}
    $cargo = readline("Ingrese el cargo del empleado: ");
	while ($cargo == ""){
		$cargo = readline("No puede estar vacio. Ingrese el cargo del empleado: ");
	}
    $empleados[] = [
		"id" => count($empleados) + 1,
        "nombre" => $nombre,
        "cargo" => $cargo
    ];

    return $empleados;
}
// funciones para las citas 

function mostrarCitas($citas){

	if(count($citas) == 0){
		echo "No hay citas registradas \n";
	}
	else{
		foreach($citas as $cita){
			echo "Empleado: " . $cita["idEmpleado"] . " Cliente: " . $cita["cliente"] . " Dia: " . $cita["dia"] . " Hora: " . $cita["hora"] . "\n";
		}
	}
}

function registrarCita($empleados, $citas, $servicios, $dias_de_la_semana){

	if(count($empleados) == 0){

		echo "No hay empleados registrados \n";

	}
	else{
				
		foreach($empleados as $emple){
		
			echo $emple["id"] . " " . "nombre: ". $emple["nombre"] . " cargo: " .$emple["cargo"] ."\n";
		
		}

		$id_empleado = readline("Seleccione el numero del empleado: ");
		$cliente = readline("Ingrese nombre del cliente: ");
		
		while($cliente == ""){
		
			$cliente = readline("No puede estar vacio. Ingrese el cliente: ");
		
		}

		echo "Dias Disponibles: ";
		foreach($dias_de_la_semana as $dia){
			echo $dia . " ";
		}
		echo "\n";
		$dia = readline("Ingrese el dia: ");
		
		while($dia != "lunes" && $dia != "martes" && $dia != "miercoles" && $dia != "jueves" && $dia != "viernes" && $dia != "sabado"){
		
			$dia = readline("Dia invalido. Ingrese el dia: ");
		
		}

		$hora = readline("Ingrese la hora: ");
		
		while($hora < 8 || $hora > 18){
		
			$hora = readline("Hora invalida. Ingrese la hora: ");
		
		}

		$citas[] = [
			"idEmpleado" => $id_empleado,
			"cliente" => $cliente,
			"dia" => $dia,
			"hora" => $hora
		];

		echo "Cita registrada \n";

	}

	return $citas;
}



////////////////////////////////////

while($op_activas){
	
	echo "====== Menu De ADSO-SPA =======\n";
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
			$citas = registrarCita($empleados, $citas, $servicios, $dias_de_la_semana);

			break;
		case 3:
			mostrarCitas($citas);

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
