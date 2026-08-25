<?php

$empleados = [];
$citas = [];
$cargos_dispo = [
    "Esteticista facial",
    "Manicurista",
    "Pedicurista",
    "Masajista",
    "Cosmetologo",
];
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

const BONIFICACION_ALTA = 0.12;
const BONIFICACION_BAJA = 0.08;
const CITAS_MINIMAS_BONI = 6;
const BONI_MEJOR_EMPLEAO = 50000;

$es_datos_prueba_cargados = false;
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


function registrar_empleado(array $empleados, array $cargos_disponibles): array
{
    $seguir = "s";

    while ($seguir == "s" || $seguir == "S") {

        $nombre = readline("Ingrese el nombre del empleado: ");
        while ($nombre == "") {
            $nombre = readline("No puede estar vacio. Ingrese el nombre del empleado: ");
        }

        echo "Cargos disponibles: \n";
        foreach ($cargos_disponibles as $index => $cargo) {
            echo ($index + 1) . ". " . $cargo . "\n";
        }

        $cargos_empleado = [];
        $seguir_cargo = "s";

        while ($seguir_cargo == "s" || $seguir_cargo == "S") {

            $num_cargo = readline("Seleccione el numero del cargo: ");
            while ($num_cargo < 1 || $num_cargo > count($cargos_disponibles)) {
                $num_cargo = readline("Cargo invalido. Seleccione el numero del cargo: ");
            }

            $cargos_empleado[] = $cargos_disponibles[$num_cargo - 1];

            $seguir_cargo = readline("¿ Desea agregar otro cargo ?  s/n: ");
        }

        $empleados[] = [
            "id" => count($empleados) + 1,
            "nombre" => $nombre,
            "cargo" => $cargos_empleado,
        ];

        $seguir = readline("¿ Desea registrar otro empleado ?  s/n: ");
    }

    return $empleados;
}


function registrar_cita(array $empleados, array $citas, array $servicios, array $dias_de_la_semana): array
{
    if (count($empleados) == 0) {
        echo "No hay empleados registrados \n";
        return $citas;
    }

    foreach ($empleados as $emple) {
        echo $emple["id"] . " " . "nombre: " . $emple["nombre"] . " cargo: " . implode(", ", $emple["cargo"]) . "\n";
    }

    $id_empleado = readline("Seleccione el numero del empleado: ");
    $empleado_existe = false;
    foreach ($empleados as $emple) {
        if ($emple["id"] == $id_empleado) {
            $empleado_existe = true;
        }
    }
    while ($empleado_existe == false) {
        $id_empleado = readline("Empleado no valido. Seleccione el numero del empleado: ");
        foreach ($empleados as $emple) {
            if ($emple["id"] == $id_empleado) {
                $empleado_existe = true;
            }
        }
    }

    $cliente = readline("Ingrese nombre del cliente: ");
    while ($cliente == "") {
        $cliente = readline("No puede estar vacio. Ingrese el cliente: ");
    }

    echo "Dias Disponibles: \n";
    foreach ($dias_de_la_semana as $dia) {
        echo $dia . "\n";
    }
    echo "\n";

    $dia = readline("Ingrese el dia: ");
    while ($dia != "lunes" && $dia != "martes" && $dia != "miercoles" && $dia != "jueves" && $dia != "viernes" && $dia != "sabado") {
        $dia = readline("Dia invalido. Ingrese el dia: ");
    }

    $hora = readline("Ingrese la hora: ");
    while ($hora < 8 || $hora > 18) {
        $hora = readline("Hora invalida. Ingrese la hora: ");
    }

    $servicios_cita = [];
    $seguir_servicio = "s";

    while ($seguir_servicio == "s" || $seguir_servicio == "S") {

        echo "Catalogo de servicios: \n";
        foreach ($servicios as $index => $serv) {
            echo ($index + 1) . ". " . $serv["nombre"] . " - $" . number_format($serv["precio"]) . " - " . $serv["duracion"] . "h\n";
        }

        $num_servicio = readline("Seleccione el numero del servicio: ");
        while ($num_servicio < 1 || $num_servicio > count($servicios)) {
            $num_servicio = readline("Servicio invalido. Seleccione el numero del servicio: ");
        }

        $servicios_cita[] = $servicios[$num_servicio - 1];

        $seguir_servicio = readline("¿ Desea agregar otro servicio ?  s/n: ");
    }

    $citas[] = [
        "id_empleado" => $id_empleado,
        "cliente" => $cliente,
        "dia" => $dia,
        "hora" => $hora,
        "servicios" => $servicios_cita,
    ];

    echo "Cita registrada \n";

    return $citas;
}


function total_facturado_por_empleado(array $empleados, array $citas)
{
    $totales = [];

    foreach ($empleados as $emple) {
        $totales[] = [
            "id" => $emple["id"],
            "nombre" => $emple["nombre"],
            "total" => 0
        ];
    }

    foreach ($citas as $cita) {
        foreach ($totales as $index => $tot) {
            if ($tot["id"] == $cita["id_empleado"]) {
                foreach ($cita["servicios"] as $serv) {
                    $totales[$index]["total"] = $totales[$index]["total"] + $serv["precio"];
                }
            }
        }
    }

    $n = count($totales);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - 1; $j++) {
            if ($totales[$j]["total"] < $totales[$j + 1]["total"]) {
                $temp = $totales[$j];
                $totales[$j] = $totales[$j + 1];
                $totales[$j + 1] = $temp;
            }
        }
    }

    echo "Empleado\tTotal Facturado\n";
    foreach ($totales as $tot) {
        echo $tot["nombre"] . "\t$" . number_format($tot["total"]) . "\n";
    }
}


function servicio_mas_solicitado(array $citas)
{
    $conteo = [];

    foreach ($citas as $cita) {
        foreach ($cita["servicios"] as $serv) {

            $encontrado = false;

            foreach ($conteo as $index => $c) {
                if ($c["nombre"] == $serv["nombre"]) {
                    $conteo[$index]["veces"] = $conteo[$index]["veces"] + 1;
                    $conteo[$index]["total"] = $conteo[$index]["total"] + $serv["precio"];
                    $encontrado = true;
                }
            }

            if ($encontrado == false) {
                $conteo[] = [
                    "nombre" => $serv["nombre"],
                    "veces" => 1,
                    "total" => $serv["precio"],
                ];
            }
        }
    }

    if (count($conteo) == 0) {
        echo "No hay servicios registrados \n";
        return;
    }

    $mas_solicitado = $conteo[0];
    foreach ($conteo as $c) {
        if ($c["veces"] > $mas_solicitado["veces"]) {
            $mas_solicitado = $c;
        }
    }

    echo "Servicio mas solicitado: " . $mas_solicitado["nombre"] . "\n";
    echo "Veces solicitado: " . $mas_solicitado["veces"] . "\n";
    echo "Total facturado: $" . number_format($mas_solicitado["total"]) . "\n";
}


function agenda_de_un_dia(array $empleados, array $citas, array $dias_de_la_semana)
{
    echo "Dias Disponibles: ";
    foreach ($dias_de_la_semana as $dia) {
        echo $dia . " ";
    }
    echo "\n";

    $dia_consulta = readline("Ingrese el dia que desea consultar: ");
    while ($dia_consulta != "lunes" && $dia_consulta != "martes" && $dia_consulta != "miercoles" && $dia_consulta != "jueves" && $dia_consulta != "viernes" && $dia_consulta != "sabado") {
        $dia_consulta = readline("Dia invalido. Ingrese el dia: ");
    }

    $citas_del_dia = [];
    foreach ($citas as $cita) {
        if ($cita["dia"] == $dia_consulta) {
            $citas_del_dia[] = $cita;
        }
    }

    if (count($citas_del_dia) == 0) {
        echo "No hay citas registradas para el dia " . $dia_consulta . "\n";
        return;
    }

    $n = count($citas_del_dia);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - 1; $j++) {
            if ($citas_del_dia[$j]["hora"] > $citas_del_dia[$j + 1]["hora"]) {
                $temp = $citas_del_dia[$j];
                $citas_del_dia[$j] = $citas_del_dia[$j + 1];
                $citas_del_dia[$j + 1] = $temp;
            }
        }
    }

    echo "Hora\tEmpleado\tCliente\tServicios\n";

    foreach ($citas_del_dia as $cita) {

        $nombre_empleado = "";
        foreach ($empleados as $emple) {
            if ($emple["id"] == $cita["id_empleado"]) {
                $nombre_empleado = $emple["nombre"];
            }
        }

        $texto_servicios = "";
        foreach ($cita["servicios"] as $serv) {
            $texto_servicios = $texto_servicios . $serv["nombre"] . ", ";
        }

        echo $cita["hora"] . "\t" . $nombre_empleado . "\t" . $cita["cliente"] . "\t" . $texto_servicios . "\n";
    }
}


function detectar_conflictos(array $empleados, array $citas)
{
    $hay_conflictos = false;
    $n = count($citas);

    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {

            $cita_a = $citas[$i];
            $cita_b = $citas[$j];

            if ($cita_a["id_empleado"] == $cita_b["id_empleado"] && $cita_a["dia"] == $cita_b["dia"]) {

                $duracion_a = 0;
                foreach ($cita_a["servicios"] as $serv) {
                    $duracion_a = $duracion_a + $serv["duracion"];
                }

                $duracion_b = 0;
                foreach ($cita_b["servicios"] as $serv) {
                    $duracion_b = $duracion_b + $serv["duracion"];
                }

                $inicio_a = (int) $cita_a["hora"];
                $fin_a = $inicio_a + $duracion_a;
                $inicio_b = (int) $cita_b["hora"];
                $fin_b = $inicio_b + $duracion_b;

                if ($inicio_a < $fin_b && $inicio_b < $fin_a) {

                    $hay_conflictos = true;

                    $nombre_empleado = "";
                    foreach ($empleados as $emple) {
                        if ($emple["id"] == $cita_a["id_empleado"]) {
                            $nombre_empleado = $emple["nombre"];
                        }
                    }

                    echo "Conflicto: " . $nombre_empleado . " el " . $cita_a["dia"];
                    echo " (" . $inicio_a . "h-" . $fin_a . "h, cliente " . $cita_a["cliente"] . ")";
                    echo " se cruza con (" . $inicio_b . "h-" . $fin_b . "h, cliente " . $cita_b["cliente"] . ") \n";
                }
            }
        }
    }

    if ($hay_conflictos == false) {
        echo "No se encontraron conflictos de agenda. \n";
    }
}


function liquidar_comisiones(array $empleados, array $citas)
{
    $resumen = [];

    foreach ($empleados as $emple) {
        $resumen[] = [
            "id" => $emple["id"],
            "nombre" => $emple["nombre"],
            "citas" => 0,
            "total" => 0,
        ];
    }

    foreach ($citas as $cita) {
        foreach ($resumen as $index => $res) {
            if ($res["id"] == $cita["id_empleado"]) {
                $resumen[$index]["citas"] = $resumen[$index]["citas"] + 1;
                foreach ($cita["servicios"] as $serv) {
                    $resumen[$index]["total"] = $resumen[$index]["total"] + $serv["precio"];
                }
            }
        }
    }

    $id_mejor_empleado = 0;
    $mayor_total = -1;
    foreach ($resumen as $res) {
        if ($res["total"] > $mayor_total) {
            $mayor_total = $res["total"];
            $id_mejor_empleado = $res["id"];
        }
    }

    echo "Empleado\tCitas\tFacturado\tComision\n";

    foreach ($resumen as $res) {

        if ($res["citas"] >= CITAS_MINIMAS_BONI) {
            $porcentaje = BONIFICACION_ALTA;
        } else {
            $porcentaje = BONIFICACION_BAJA;
        }

        $comision = $res["total"] * $porcentaje;

        if ($res["id"] == $id_mejor_empleado) {
            $comision = $comision + BONI_MEJOR_EMPLEAO;
        }

        echo $res["nombre"] . "\t" . $res["citas"] . "\t$" . number_format($res["total"]) . "\t$" . number_format($comision) . "\n";
    }
}


function cargar_datos_prueba(array $servicios, array $cargos_disponibles): array
{


    $empleados = [
        [
			"id" => 1, 
			"nombre" => "Luisca", 
			"cargo" => [$cargos_disponibles[0]]
		],
        [
			"id" => 2, 
			"nombre" => "Luis Frias", 
			"cargo" => [$cargos_disponibles[1], $cargos_disponibles[2]]
		],
        [
			"id" => 3, 
			"nombre" => "Luis Torres", 
			"cargo" => [$cargos_disponibles[3]]
		],
        [
			"id" => 4, 
			"nombre" => "Dosa Prime", 
			"cargo" => [$cargos_disponibles[4]]
		],
    ];

    $citas = [
        [
			"id_empleado" => 1, 
			"cliente" => "Cliente 1",  
			"dia" => "lunes",     
			"hora" => 8,  
			"servicios" => [$servicios[0]]
		],
        [
			"id_empleado" => 1, 
			"cliente" => "Cliente 2",  
			"dia" => "lunes",     
			"hora" => 9,  
			"servicios" => [$servicios[1]]
		],
        [
			"id_empleado" => 1, 
			"cliente" => "Cliente 3",  
			"dia" => "martes",    
			"hora" => 8,  
			"servicios" => [$servicios[2]]
		],
        [
			"id_empleado" => 1, 
			"cliente" => "Cliente 4",  
			"dia" => "martes",    
			"hora" => 10, 
			"servicios" => [$servicios[3], $servicios[5]]
		],
        [
            "id_empleado" => 1, 
            "cliente" => "Cliente 5",  
            "dia" => "miercoles", 
            "hora" => 8,  
            "servicios" => [$servicios[6]]
        ],

        [
            "id_empleado" => 2, 
            "cliente" => "Cliente 6",  
            "dia" => "lunes",     
            "hora" => 8,  
            "servicios" => [$servicios[1], $servicios[2]]
        ],
        [
            "id_empleado" => 2, 
            "cliente" => "Cliente 7",  
            "dia" => "martes",    
            "hora" => 9,  
            "servicios" => [$servicios[4]]
        ],
        [
            "id_empleado" => 2, 
            "cliente" => "Cliente 8",  
            "dia" => "miercoles", 
            "hora" => 8,  
            "servicios" => [$servicios[0], $servicios[1]]
        ],
        [
            "id_empleado" => 2, 
            "cliente" => "Cliente 9",  
            "dia" => "jueves",    
            "hora" => 8,  
            "servicios" => [$servicios[2]]
        ],

        [
            "id_empleado" => 3, 
            "cliente" => "Cliente 10", 
            "dia" => "lunes",     
            "hora" => 10, 
            "servicios" => [$servicios[3]]
        ],
        [
            "id_empleado" => 3, 
            "cliente" => "Cliente 11", 
            "dia" => "martes",    
            "hora" => 8,  
            "servicios" => [$servicios[6], $servicios[1]]
        ],
        [
            "id_empleado" => 3, 
            "cliente" => "Cliente 12", 
            "dia" => "miercoles", 
            "hora" => 9,  
            "servicios" => [$servicios[5]]
        ],

        [
            "id_empleado" => 4, 
            "cliente" => "Cliente 13", 
            "dia" => "lunes",     
            "hora" => 8,  
            "servicios" => [$servicios[4]]
        ],
        [
            "id_empleado" => 4, 
            "cliente" => "Cliente 14", 
            "dia" => "martes",    
            "hora" => 8,  
            "servicios" => [$servicios[0], $servicios[2]]
        ],
        [
            "id_empleado" => 4, 
            "cliente" => "Cliente 15", 
            "dia" => "viernes",   
            "hora" => 8,  
            "servicios" => [$servicios[1]]
        ],
    ];











    return [
        "empleados" => $empleados,
        "citas" => $citas,
    ];
}


function salida_programa()
{
    echo "Fue un placer tenerte aca, hasta luego !";
    exit;
}


//

echo "======= Bienvenido, ADSO-SPA =======\n";
echo " \n";
while ($es_activa) {

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

    switch ($opcion) {
        case 1:
            if ($es_datos_prueba_cargados == true) {
                echo "Los datos de prueba ya fueron cargados. \n";
            } 
            else {
                $empleados = registrar_empleado($empleados, $cargos_dispo);
            }
            
            break;
        case 2:
            if ($es_datos_prueba_cargados == true) {
                echo "Los datos de prueba ya fueron cargados. \n";
            } 
            else {
                $citas = registrar_cita($empleados, $citas, $servicios, $dias_de_la_semana);
            }
            
            break;
        case 3:
            total_facturado_por_empleado($empleados, $citas);
            break;
        case 4:
            servicio_mas_solicitado($citas);
            break;
        case 5:
            agenda_de_un_dia($empleados, $citas, $dias_de_la_semana);
            break;
        case 6:
            detectar_conflictos($empleados, $citas);
            break;
        case 7:
            liquidar_comisiones($empleados, $citas);
            break;
        case 8:
            salida_programa();
            break;
        case "dp":
            if ($es_datos_prueba_cargados == true) {
                echo "Los datos de prueba ya fueron cargados. \n";
            } else {
                $datos = cargar_datos_prueba($servicios, $cargos_dispo);
                $empleados = $datos["empleados"];
                $citas = $datos["citas"];
                $es_datos_prueba_cargados = true;
                echo "Datos de prueba cargados correctamente... \n";
            }
            break;
        default:
            echo "Opcion no valida\n";
            break;
    }
}

?>
