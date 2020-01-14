<?php
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=arqueo_vitalea.xls');
?>

<table border="1" cellpadding="2" cellspacing="4" width="77%">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #14988a; color:white;">ARCHIVO DE ARQUEO VITALEA</th>
        </tr>
        <tr>
            <th style="background-color: #214761; color:white;">Rango de Fechas</th>
            <th style="background-color: #214761; color:white;">Asesor</th>
            <th style="background-color: #214761; color:white;">Fecha de la consulta</th>
            <th colspan="5" rowspan="2"></th>
        </tr>
        <tr>
            <th>xxxxxxxxxx</th>
            <th>xxxxxxxxxx</th>
            <th>xxxxxxxxxx</th>
        </tr>
        <tr>
            <th style="background-color: #214761; color:white;">Fecha de Venta</th>
            <th style="background-color: #214761; color:white;">Factura</th>
            <th style="background-color: #214761; color:white;">Medio de Pago</th>
            <th style="background-color: #214761; color:white;">Asesor</th>
            <th style="background-color: #214761; color:white;">Documento Asesor</th>
            <th style="background-color: #214761; color:white;">Paciente</th>
            <th style="background-color: #214761; color:white;">Documento Paciente</th>
            <th style="background-color: #214761; color:white;">Total Venta</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Fecha de Venta</td>
            <td>Factura</td>
            <td>Medio de Pago</td>
            <td>Asesor</td>
            <td>Documento Asesor</td>
            <td>Paciente</td>
            <td>Documento Paciente</td>
            <td>Total Venta</td>
        </tr>
    </tbody>
</table>