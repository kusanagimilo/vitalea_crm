<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WS
 *
 * @author JuanCamilo
 */
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once '../conexion/conexion_bd.php';

class WS {

    public $Username = '';
    public $Password = '';

    public function __construct($Username, $Password) {
        $this->Username = $Username;
        $this->Password = $Password;
    }

    public function CrearPaciente($id_venta) {


        $conexion = new Conexion();

        $query = $conexion->prepare("SELECT cli.id_cliente,cli.tipo_documento,cli.documento,cli.fecha_nacimiento,cli.nombre,cli.apellido,
cli.sexo,cli.direccion,CONCAT(ci.nombre,' - ',dpto.nombre) AS ubicacion,cli.estrato,
cli.email,cli.estado_civil_id,cli.id_cliente_athenea,cli.telefono_1,ci.codigo
FROM cliente cli
INNER JOIN ciudad ci ON ci.id = cli.ciudad_id
INNER JOIN departamento dpto ON dpto.id = ci.departamento_id
INNER JOIN venta ven ON ven.cliente_id = cli.id_cliente
WHERE ven.id =:id");


        $query->execute(array(':id' => $id_venta));
        $arreglo = $query->fetchAll(PDO::FETCH_ASSOC);



        $par = array();
        $client = new SoapClient("http://190.60.101.55/WebServices/Laboratorio/DatosGenerales/WSIntegracionLaboratorio.asmx?WSDL", $par);
        $headers = new SoapHeader("http://tempuri.org/", 'ServiceAuthHeader', new WS("AtheneaWS", "4th3n3a*"));
        $client->__setSoapHeaders($headers);




        $tipo_documento = "";
        if ($arreglo[0]["tipo_documento"] == 1) {
            $tipo_documento = "CC";
        } else if ($arreglo[0]["tipo_documento"] == 2) {
            $tipo_documento = "TI";
        } else if ($arreglo[0]["tipo_documento"] == 3) {
            $tipo_documento = "CE";
        }

        $sexo = "";

        if ($arreglo[0]["sexo"] == "Masculino") {
            $sexo = "M";
        } else if ($arreglo[0]["sexo"] == "Femenino") {
            $sexo = "F";
        }
        
        $xml_ingresar_paciente = "<ROOT>
 		<SOLICITUD NUEVO='1' USUARIOGENERO='LABIT' IDENTIFICADOR='' TIPOHOMOLOGACION=''>
 		<PACIENTE>
         	<TIPOIDENTIFICACION>$tipo_documento</TIPOIDENTIFICACION>
		<NUMEROIDENTIFICACION>" . $arreglo[0]['documento'] . "</NUMEROIDENTIFICACION>
		<FECHANACIMIENTO>" . $arreglo[0]['fecha_nacimiento'] . "T00:00:00</FECHANACIMIENTO>
                <NOMBRE1>" . $arreglo[0]['nombre'] . "</NOMBRE1>
                <APELLIDO1>" . $arreglo[0]['apellido'] . "</APELLIDO1>
                <SEXO>" . $sexo . "</SEXO>
		<ACTIVO>1</ACTIVO>
                <D0 BID='0' HOMOLOGAR='0'></D0>
		<D1 BID='0' HOMOLOGAR='0'></D1>
		<D2 BID='0' HOMOLOGAR='0'></D2>
		<D3 BID='0' HOMOLOGAR='0'></D3>
		<D4 BID='0' HOMOLOGAR='0'></D4>
		<D5 BID='0' HOMOLOGAR='0'></D5>
		<D6 BID='0' HOMOLOGAR='0'></D6>
		<D7 BID='0' HOMOLOGAR='0'></D7>
		<D8 BID='0' HOMOLOGAR='0'></D8>
		<D9 BID='0' HOMOLOGAR='0'></D9>
                <DIMENSIONESVARIABLES>
                <DIMENSION>
 		<NUMERO>10</NUMERO>
		<VALOR>" . $arreglo[0]['codigo'] . "</VALOR>
 		</DIMENSION>
                <DIMENSION>
 		<NUMERO>11</NUMERO>
		<VALOR>1</VALOR>
 		</DIMENSION>
		<DIMENSION>
 		<NUMERO>12</NUMERO>
		<VALOR>" . $arreglo[0]['estrato'] . "</VALOR>
 		</DIMENSION>
                <DIMENSION>
 		<NUMERO>13</NUMERO>
		<VALOR>1</VALOR>
 		</DIMENSION>
 		<DIMENSION>
 		<NUMERO>14</NUMERO>
		<VALOR>" . $arreglo[0]['direccion'] . "</VALOR>
 		</DIMENSION>
 		<DIMENSION>
 		<NUMERO>15</NUMERO>
		<VALOR>" . $arreglo[0]['telefono_1'] . "</VALOR>
 		</DIMENSION>
 		<DIMENSION>
 		<NUMERO>16</NUMERO>
 		<VALOR>" . $arreglo[0]['email'] . "</VALOR>
 		</DIMENSION>
                <DIMENSION>
 		<NUMERO>33</NUMERO>
 		<VALOR>" . $arreglo[0]['email'] . "</VALOR>
 		</DIMENSION>
 		</DIMENSIONESVARIABLES>
		 </PACIENTE>
 		</SOLICITUD>
 		</ROOT>";


        $datos = array("CrearPaciente" =>
            array("strXml" => $xml_ingresar_paciente));


        $result = $client->__soapCall("CrearPaciente", $datos);


        $xml = simplexml_load_string($result->CrearPacienteResult);



        $arreglo = array("xml" => $xml,
            "tipo_documento" => $tipo_documento,
            "documento" => $arreglo[0]['documento'],
            "id_paciente" => $arreglo[0]['id_cliente']);

        return $arreglo;
    }

    function AlmacenarFactura($id_venta) {

        $conexion = new Conexion();

        $query = $conexion->prepare("SELECT cli.id_cliente,cli.tipo_documento,cli.documento,cli.fecha_nacimiento,cli.nombre,cli.apellido,
cli.sexo,cli.direccion,CONCAT(ci.nombre,' - ',dpto.nombre) AS ubicacion,cli.estrato,
cli.email,cli.estado_civil_id,cli.id_cliente_athenea,cli.telefono_1,ven.id,ven.medio_pago,plan.id_plan,plan.codigo_plan
FROM cliente cli
INNER JOIN ciudad ci ON ci.id = cli.ciudad_id
INNER JOIN departamento dpto ON dpto.id = ci.departamento_id
INNER JOIN venta ven ON ven.cliente_id = cli.id_cliente
INNER JOIN plan ON plan.id_plan = ven.id_plan
WHERE ven.id =:id");


        $query->execute(array(':id' => $id_venta));
        $arreglo = $query->fetchAll(PDO::FETCH_ASSOC);

        $plan = $arreglo[0]['codigo_plan'];



        $par = array();
        $client = new SoapClient("http://190.60.101.55/WebServices/Laboratorio/DatosGenerales/WSIntegracionLaboratorio.asmx?WSDL", $par);
        $headers = new SoapHeader("http://tempuri.org/", 'ServiceAuthHeader', new WS("AtheneaWS", "4th3n3a*"));
        $client->__setSoapHeaders($headers);

        $tipo_documento = "";
        if ($arreglo[0]["tipo_documento"] == 1) {
            $tipo_documento = "CC";
        } else if ($arreglo[0]["tipo_documento"] == 2) {
            $tipo_documento = "TI";
        } else if ($arreglo[0]["tipo_documento"] == 3) {
            $tipo_documento = "CE";
        }



        $xml = '<ROOT>
                <SOLICITUD NUEVO="1" USUARIOGENERO="LABIT" IDENTIFICADOR="" TIPOHOMOLOGACION="">
                <PACIENTE>
                   <TIPOIDENTIFICACION>' . $tipo_documento . '</TIPOIDENTIFICACION>
                    <NUMEROIDENTIFICACION>' . $arreglo[0]['documento'] . '</NUMEROIDENTIFICACION>
                </PACIENTE>
                <CABECERA>
                <DETALLECOMENTARIO />
                    <D0>113</D0>
                    <D1>' . $plan . '</D1>
                    <D2>1</D2>
                    <D3>1</D3>
                    <D4></D4>
                    <D5 BID="0" HOMOLOGAR="0" />
                    <D8 BID="0" HOMOLOGAR="0" />
                    <D9 BID="0" HOMOLOGAR="0" />
                </CABECERA>
                <DETALLESOLICITUD>';

        $query_examenes = $conexion->prepare("select * from venta_items where venta_id =:id_venta");

        $query_examenes->execute(array(':id_venta' => $id_venta));
        $arreglo_examenes = $query_examenes->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        $arreglo_examenes_completo = [];
        foreach ($arreglo_examenes as $key => $value) {

            if ($value['tipo_examen'] == 1) {
                $query_perfiles = $conexion->prepare("SELECT id,codigo_crm,precio FROM examen WHERE id =:examen_id");
                $query_perfiles->execute(array(':examen_id' => $value['examen_id']));
                $arreglo_examenes_p = $query_perfiles->fetchAll(PDO::FETCH_ASSOC);
                $arreglo_examenes_completo[$i]["valor"] = $value['valor'];
                $arreglo_examenes_completo[$i]["codigo"] = $arreglo_examenes_p[0]['codigo_crm'];
            } else if ($value['tipo_examen'] == 2) {
                $query_no_perfiles = $conexion->prepare("select id,codigo,precio from examenes_no_perfiles where id =:examen_id");
                $query_no_perfiles->execute(array(':examen_id' => $value['examen_id']));
                $arreglo_examenes_nop = $query_no_perfiles->fetchAll(PDO::FETCH_ASSOC);
                $arreglo_examenes_completo[$i]["valor"] = $value['valor'];
                $arreglo_examenes_completo[$i]["codigo"] = $arreglo_examenes_nop[0]['codigo'];
            }
            $i++;
        }


        /* $query_examenes = $conexion->prepare("select exm.codigo,itm.valor 
          from venta_items itm
          INNER JOIN examenes_no_perfiles exm ON exm.id = itm.examen_id
          where itm.venta_id =:id_venta
          and itm.tipo_examen =:tipo_examen");

          $query_examenes->execute(array(':id_venta' => $id_venta,
          ':tipo_examen' => 2));
          $arreglo_examenes = $query_examenes->fetchAll(PDO::FETCH_ASSOC); */




        $valor = 0;
        foreach ($arreglo_examenes_completo as $key => $value) {
            $valor = $valor + (int) $value['valor'];

            $xml .= "<DETALLE>
                        <CODIGOPARAMETRO>" . $value['codigo'] . "</CODIGOPARAMETRO>
                    </DETALLE>";
        }

        $xml .= '</DETALLESOLICITUD>
            </SOLICITUD>
        </ROOT>';

        //return $xml;
        //var_dump($valor);
        //die();



        if ($arreglo[0]["medio_pago"] == "2" || $arreglo[0]["medio_pago"] == 2) {
            $forma_pago = 1;
        } else {
            $forma_pago = 2;
        }

        //formas de pago 1 = efectivo ; 2 =tarjeta
        //414, 104000
        $datos = array("CrearSolicitudConFactura" =>
            array("strXml" => $xml,
                "formasPago" => array(
                    "formaPago" => array(
                        "idFormaPago" => $forma_pago,
                        "valor" => $valor
                    )),
                "totalFactura" => $valor,
                "intIdplan" => $plan));

        $result = $client->__soapCall("CrearSolicitudConFactura", $datos);


        // return var_dump($result);
        //$datos_resultado = $result->CrearSolicitudConFacturaResult->solicitudActualizada;

        $retorno = array();

        if (isset($result->CrearSolicitudConFacturaResult->solicitudActualizada)) {
            $datos_resultado = $result->CrearSolicitudConFacturaResult->solicitudActualizada;
            $mensaje = $datos_resultado->strMensajeActualizacion;

            if (trim($mensaje) == "Solicitud actualizada correctamente") {
                //return var_dump($datos_resultado);
                $retorno["NumeroFactura"] = trim($datos_resultado->strNumeroFactura);
                $retorno["NumeroSolicitud"] = trim($datos_resultado->strNumeroSolicitud);
                $retorno["Id_Solicitud"] = trim($datos_resultado->intIDSolicitud);
                $retorno["Facturado"] = "SI";
                $retorno["ValorAthenea"] = $valor;
            } else if (trim($datos_resultado->intIDSolicitud) == 0) {

                $retorno = "error";
            } else {
                $mensaje = $datos_resultado->strMensajeActualizacion;
                $arreglo = explode(".", $mensaje);
                $arreglo_2 = explode(" V", $arreglo[1]);
                $valor_calculado_athenea = explode(":", $arreglo_2[0]);
                $valor_enviado_crm = explode(":", $arreglo_2[1]);
                $retorno["NumeroFactura"] = "NO";
                $retorno["NumeroSolicitud"] = trim($datos_resultado->strNumeroSolicitud);
                $retorno["Id_Solicitud"] = trim($datos_resultado->intIDSolicitud);
                $retorno["Facturado"] = "NO";
                $retorno["ValorAthenea"] = trim($valor_calculado_athenea[1]);
            }

            return $retorno;
        } else {
            return "error";
        }

        //return var_dump($datos_resultado);
    }

}
