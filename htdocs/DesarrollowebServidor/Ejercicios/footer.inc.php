<?php
$Numero_dia = date('w');
$Dia_Semana = date('d');
$mes = date('n');
$año = date('Y');

switch ($Numero_dia) {
    case 0:
        $Nombre_dia = 'Domingo';
        break;
    case 1:
        $Nombre_dia = 'Lunes';
        break;
    case 2:
        $Nombre_dia = 'Martes';
        break;
    case 3:
        $Nombre_dia = 'Miércoles';
        break;
    case 4:
        $Nombre_dia = 'Jueves';
        break;
    case 5:
        $Nombre_dia = 'Viernes';
        break;
    case 6:
        $Nombre_dia = 'Sábado';
        break;

    default:
        break;
}


switch ($mes) {
    case 1:
        $Nombre_mes = 'Enero';
        break;
    case 2:
        $Nombre_mes = 'Febrero';
        break;
    case 3:
        $Nombre_mes = 'Marzo';
        break;
    case 4:
        $Nombre_mes = 'Abril';
        break;
    case 5:
        $Nombre_mes = 'Mayo';
        break;
    case 6:
        $Nombre_mes = 'Junio';
        break;
    case 7:
        $Nombre_mes = 'Julio';
        break;
    case 8:
        $Nombre_mes = 'Agosto';
        break;
    case 9:
        $Nombre_mes = 'Septiembre';
        break;
    case 10:
        $Nombre_mes = 'Octubre';
        break;
    case 11:
        $Nombre_mes = 'Noviembre';
        break;

    case 12:
        $Nombre_mes = 'Diciembre';
        break;
    default:
        break;

    
}
?>
<footer>
<p>
    <?php echo "" . $Nombre_dia . ", " . $Dia_Semana . " de " . $Nombre_mes . " de " . $año; ?>
</p>
</footer>

