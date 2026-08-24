<?php

$empleados = [];
$citas = [];
$dias_de_la_semana = [
	"lunes", 
	"martes", 
	"miercoles", 
	"jueves", 
	"viernes", 
	"sabado"
	];

$es_activa = true;
$es_activas_register = true;
$i = 0;

$servicios = [
    [   
        "nombre" => "Limpieza facial",
        "precio" => 80000,
        "duracion" => 2
    ],

    [
        "nombre" => "Manicure",
        "precio" => 35000,
        "duracion" => 1
    ],
    [
        "nombre" => "Pedicure",                  
        "precio" => 40000,  
        "duracion" => 1
    ],
    [
        "nombre" => "Masaje relajante",          
        "precio" => 90000,  
        "duracion" => 1
    ],
    [
        "nombre" => "Masaje descontracturante",  
        "precio" => 100000, 
        "duracion" => 1
    ],
    [
        "nombre" => "Exfoliación corporal",      
        "precio" => 60000,  
        "duracion" => 1
    ],
    [
        "nombre" => "Tratamiento antiedad",      
        "precio" => 120000, 
        "duracion" => 2
    ],
];






function registrar_empleado(array $empleados) {
    $nombre = readline("Ingrese el nombre del empleado: ");
    while ($nombre == "") {
        $nombre = readline("No puede estar vacio. Ingrese el nombre del empleado: ");
    }

    $cargo = readline("Ingrese el cargo del empleado: ");
    while ($cargo == "") {
        $cargo = readline("No puede estar vacio. Ingrese el cargo del empleado: ");
    }
    
    $empleados[] = [
        "id" => count($empleados) + 1,
        "nombre" => $nombre,
        "cargo" => $cargo
    ];


    
	do {

        $op_register_empleado = readline("¿ Desea registrar empleado ?  s/n: ");

        if ($op_register_empleado == "s" || $op_register_empleado == "S") {
            $empleados = registrar_empleado($empleados);
        } 
		else if ($op_register_empleado == "n" || $op_register_empleado == "N") {
            break;
        } 
		else {
            echo "Opcion invalida \n";
        }
    }	while($op_register_empleado != "n" || $op_register_empleado != "N");

    return $empleados;
}







function mostrar_citas(array $citas){

	if(count($citas) == 0){
		echo "No hay citas registradas \n";
	}
	else{
		foreach($citas as $cita){
			echo "Empleado: " . $cita["id_empleado"] . " Cliente: " . $cita["cliente"] . " Dia: " . $cita["dia"] . " Hora: " . $cita["hora"] . "\n";
		}
	}
	
	return $citas;
}






function registrar_cita(array $empleados, array $citas, array $servicios, array $dias_de_la_semana){

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

		echo "Dias Disponibles: \n";

		foreach($dias_de_la_semana as $dia){
			echo $dia . " " . "\n";
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
			"id_empleado" => $id_empleado,
			"cliente" => $cliente,
			"dia" => $dia,
			"hora" => $hora
		];

		echo "Cita registrada \n";

	}

	return $citas;
}


function total_facturado_por_empleado(array $empleados, array $citas){

	$totales = [];

	foreach($empleados as $emple){
		$totales[] = [
			"id" => $emple["id"],
			"nombre" => $emple["nombre"],
			"total" => 0
		];
	}

	foreach($citas as $cita){
		foreach($totales as $index => $tot){
			if($tot["id"] == $cita["id_empleado"]){
				foreach($cita["servicios"] as $serv){
					$totales[$index]["total"] = $totales[$index]["total"] + $serv["precio"];
				}
			}
		}
	}

	$n = count($totales);
	for($i = 0; $i < $n; $i++){
		for($j = 0; $j < $n - 1; $j++){
			if($totales[$j]["total"] < $totales[$j+1]["total"]){
				$temp = $totales[$j];
				$totales[$j] = $totales[$j+1];
				$totales[$j+1] = $temp;
			}
		}
	}

	echo "Empleado" . "Total Facturado\n";
	foreach($totales as $tot){
		echo str_pad($tot["nombre"], 20) . "$" . number_format($tot["total"]) . "\n";
	}

}



function salida_programa(){
	echo "Fue un placer tenerte aca, hasta luego !";
	exit;
}





//

echo "======= Bienvenido, ADSO-SPA =======\n";
echo " \n";
while($es_activa){
	
	echo "========= Menu De ADSO-SPA ========\n";
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
			$empleados = registrar_empleado($empleados);
			break;
		case 2:
			$citas = registrar_cita($empleados, $citas, $servicios, $dias_de_la_semana);
			break;
		case 3:
			total_facturado_por_empleado($empleados, $citas);
			break;
		case 4:

			mostrar_citas($citas);
			break;
		case 5:


			break;
		case 6:


			break;
		case 7:


			break;
		case 8:

			salida_programa();
			break;
		case "dp":

			break;

		default:
			echo "Opcion no valida\n";
			break;
	}
}

?>




