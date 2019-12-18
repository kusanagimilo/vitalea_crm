<?php 
/**
 * Description of Gestion
 *
 * @author Paola Cotrina
 */
require_once '../conexion/conexion_bd.php';

class GenerarPDF {
    public $conexion;
    
    function __construct() {
        $this->conexion = new Conexion();
    } 


    function generarPdf($cotizacion_id,$cliente_id){

      //DATOS DE LA FACTURA

      $informacion_cotizacion = $this->consultarCotizacion($cotizacion_id,$cliente_id);

      foreach ($informacion_cotizacion as $datos_cotizacion) {
         $numero_factura   = $cotizacion_id;
         $fecha_cotizacion = $datos_cotizacion["fecha_cotizacion"];
         $tipo_documento   = $datos_cotizacion["tipo_documento"];
         $documento        = $datos_cotizacion["documento"];
         $nombre_cliente   = $datos_cotizacion["nombre"];
         $direccion        = $datos_cotizacion["direccion"];
         $telefono_1       = $datos_cotizacion["telefono_1"];
         $usuario          = $datos_cotizacion["usuario"];
      }

      $opcion =1;
      require_once('Cotizacion.php');
      $cotizacion = new Cotizacion();
      $html ='
              <style type="text/css">

            table { vertical-align: top; }
            tr    { vertical-align: top; }
            td    { vertical-align: top; }
            .midnight-blue{
              background:#2c3e50;
              padding: 4px 4px 4px;
              color:white;
              font-weight:bold;
              font-size:12px;
            }
            .silver{
              background:white;
              padding: 3px 4px 3px;
            }
            .clouds{
              background:#ecf0f1;
              padding: 3px 4px 3px;
            }
            .border-top{
              border-top: solid 1px #bdc3c7;
              
            }
            .border-left{
              border-left: solid 1px #bdc3c7;
            }
            .border-right{
              border-right: solid 1px #bdc3c7;
            }
            .border-bottom{
              border-bottom: solid 1px #bdc3c7;
            }
            table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
            }

            </style>


            <page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
                    <page_footer>
                    <table class="page_footer">
                        <tr>

                            <td style="width: 50%; text-align: left">
                                P&aacute;gina [[page_cu]]/[[page_nb]]
                            </td>
                            <td style="width: 50%; text-align: right">
                                &copy; Vitalea '.  $anio=date('Y').'
                            </td>
                        </tr>
                    </table>
                </page_footer>
               <table cellspacing="0" style="width: 100%;">
                    <tr>

                        <td style="width: 25%; color: #444444;">
                           VITALEA
                       
                            
                        </td>
                  <td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
                            <span style="color: #34495e;font-size:14px;font-weight:bold">Cotizacion</span>
                    <br>Vitalea<br> 
                    Teléfono: 057-7890000 <br>
                    Email: informacion@vitalea.com
                        </td>
                  <td style="width: 25%;text-align:right">
                  COTIZACION Nº '.$cotizacion_id .' </td>
                  
                    </tr>
                </table>
                  <br>
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
                    <tr>
                       <td style="width:50%;" class="midnight-blue">FACTURAR A</td>
                    </tr>
                <tr>
                       <td style="width:50%;" >
                        '. $nombre_cliente .' <br>
                        '. $direccion .' <br>
                        '.  $telefono_1 .'
                     </td>
                  </tr>
               </table>
                  
                     <br>
                  <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
                      <tr>
                         <td style="width:35%;" class="midnight-blue">VENDEDOR</td>
                    <td style="width:25%;" class="midnight-blue">FECHA</td>';
         
              $html.= '</tr>
                  <tr>
                   <td style="width:35%;">'. $usuario.' </td>
              <td style="width:25%;">'.$fecha_cotizacion.'</td>';

          
                $html.= ' </tr> </table><br>
              
                <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
                  <tr>
                      <th style="width: 10%;text-align:center" class="midnight-blue">CANT.</th>
                      <th style="width: 60%" class="midnight-blue">DESCRIPCION</th>
                      <th style="width: 15%;text-align: right" class="midnight-blue">DESCUENTO</th>
                      <th style="width: 15%;text-align: right" class="midnight-blue">PRECIO TOTAL</th>
                      
                  </tr>';

       
         $listado_cotizacion = $cotizacion->consultar_items_cotizacion($cotizacion_id);

         foreach ($listado_cotizacion as $item) {  
             $html.= ' <tr>
                  <td class="silver" style="width: 10%; text-align: center">1</td>
                  <td class="clouds" style="width: 60%; text-align: left">'. $item["examen"] .'</td>
                  <td class="silver" style="width: 15%; text-align: right">'. $item["descuento"] .'</td>
                  <td class="silver" style="width: 15%; text-align: right">'. number_format($item["valor"],0,',','.') .'</td>
                  
              </tr>';
         } 

           $suma_cotizacion = $cotizacion->suma_cotizacion($cotizacion_id);

          /* if($suma_cotizacion == 0){
              $suma_cotizacion = 0;
           }
           else{
            //$suma_cotizacion = number_format($suma_cotizacion,0,','.'.');
            $suma_cotizacion  = $suma_cotizacion ;
           }*/
         
          $html.= '<tr>
                    <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL $</td>
                    <td style="widtd: 15%; text-align: right;">'. $suma_cotizacion  .'</td>
                  </tr>
                  </table>
                   </page>  ';
      return $html;
    }

    public function consultarCotizacion($cotizacion_id,$cliente_id){
        $query = $this->conexion->prepare("SELECT 
          c.fecha_cotizacion,
          (SELECT nombre FROM tipo_documento where id= cl.tipo_documento) as tipo_documento,
          cl.documento,
          CONCAT(cl.nombre,' ',cl.apellido) as nombre,
          cl.direccion,
          cl.telefono_1,
          (SELECT nombre_completo FROM usuario WHERE id= c.usuario_id ) as usuario
          FROM cotizacion as c
          INNER JOIN cliente as cl ON cl.id_cliente = c.cliente_id
          WHERE c.id = :cotizacion_id  AND c.cliente_id = :cliente_id");

        $query->execute(array(':cotizacion_id'=>$cotizacion_id,
                              ':cliente_id'=>$cliente_id
                          ));

         $rows = $query->fetchAll(PDO::FETCH_ASSOC);

          return $rows;


    }

     





}    

?>