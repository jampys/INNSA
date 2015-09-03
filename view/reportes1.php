<html>

<head>

    <style type="text/css">

        #tabla_cuerpo tr td{
            background-color: ivory;
            height: 20px;
            vertical-align: middle;
            text-align: center;
            padding: 1px 10px 1px 10px;
            padding-bottom: 1px;

        }

        #tabla_cursos tr td{
            background-color: #f1f1f1;
            height: 20px;
            vertical-align: middle;
            font-size: 10px;
            padding-top: 1px;
            padding-bottom: 1px;
        }
        #tabla_cursos{
            position: fixed;
            z-index: 100; /* para que siempre se mantenga al frente */
        }

        #tabla_empleados tr td{
            background-color: #f1f1f1;
            width: 120px;
            font-size: 10px;
            text-align: center;
            padding-top: 1px;
            padding-bottom: 1px;
        }

        /* estilos para el tooltip */
        .example-content {
            position:absolute;
            bottom: 25px;
            left: 25px;
            height: auto;
            width: 150px;
            background:#2E3732;
            color: #FFFFFF;
            display:none;
            text-shadow: none;
            z-index: 1000;
            padding: 5px;
            line-height: 19px;
            text-align: left /*justify; */
            opacity: 0.8;
        }
        .tooltip-target {
            display: block; /* required */
            position: relative; /* required */
        }



    </style>

    <script type="text/javascript" language="javascript">

        $(document).ready(function(){

            $(".tooltip-target").mouseenter(function(e){
                e.preventDefault();
                $(this).children(".example-content").fadeIn("slow");
            });
            $(".tooltip-target").mouseleave(function(e){
                e.preventDefault();
                $(this).children(".example-content").fadeOut("fast");
            });



            //alert($('#tabla_empleados').find('tr')[0].cells.length);
            var tam=$('#tabla_empleados').find('tr')[0].cells.length*120+600;
            $('.reporte').width(tam);
            $('.cuerpo').width(tam-500);

            /*
            $('#categoria').change(function(){
                //alert('cambio la categoria');
                $('#tabla_cursos').toggleClass('clase1');
                $('#tabla_cuerpo').toggleClass('clase1');

            }); */

            //para filtrar por categorias de cursos
            $(document).on('change', '#categoria',  function() {
                if($(this).val()==0){
                    $('#tabla_cursos tr').show();
                    $('#tabla_cuerpo tr').show();
                }
                else {

                    $('#tabla_cursos tr').hide();
                    $('#tabla_cuerpo tr').hide();

                    $('#tabla_cursos').find('.rowToggle' + $(this).val()).show();
                    $('#tabla_cuerpo').find('.rowToggle' + $(this).val()).show();
                }

            });


            //para filtrar empleados por lugar de trabajo
            $(document).on('change', '#lugar_trabajo',  function() {
                if($(this).val()==0){
                    $('#tabla_empleados tr td').show();
                    $('#tabla_cuerpo tr td').show();
                }
                else {

                    $('#tabla_empleados tr td').hide();
                    $('#tabla_cuerpo tr td').hide();

                    $('#tabla_empleados').find('.colToggle' + $(this).val()).show();
                    $('#tabla_cuerpo').find('.colToggle' + $(this).val()).show();
                    //$('.colToggleBO').show();
                    //var tam=$('#tabla_empleados').find('tr')[0].cells.length*120+600;
                    var cant=$('#tabla_empleados tr:first').find('.colToggle'+$(this).val()).length;
                    //alert(cant);
                    var tam=cant*120+500;
                    $('.reporte').width(tam);
                    $('.cuerpo').width(tam-500);
                }

            });


            //Funcionalidad para resaltar la fila sobre la que se encuentra posicionado
            /*
            $('#tabla_cuerpo tr').hover(
                function(){
                    //$(this).find('td').addClass('tr_hover');
                    $(this).find('td').css('background-color', '#ffccee');
                },
                function(){
                    $(this).find('td').css('background-color', 'ivory');
                }
            );
            */

            var index;
            $('#tabla_cuerpo tr').hover(
                function(){
                    index =$('#tabla_cuerpo tr').index($(this));
                    //alert(index);
                    $('#tabla_cuerpo').find('tr').eq(index).find('td').css('background-color', '#FFD699'); //ffeeee
                    $('#tabla_cursos').find('tr').eq(index).find('td').css('background-color', '#FFD699');

                },
                function(){
                    $('#tabla_cuerpo').find('tr').eq(index).find('td').css('background-color', 'ivory');
                    $('#tabla_cursos').find('tr').eq(index).find('td').css('background-color', '#f1f1f1');
                }

            );


        });



        $(window).scroll(function(){
            $('#div_tabla_cursos').css({
                'margin-top': - $(this).scrollTop()
            });

        });

    </script>


</head>

<body>




<?php

//$ejeCursos=array('curso1', 'curso2', 'curso3');
//echo $ejeCursos[0];

/*
$ejeEmpleados=array('empleado1', 'empleado2', 'empleado3', 'empleado4', 'empleado5', 'empleado6', 'empleado7', 'empleado8', 'empleado9', 'empleado10',
    'empleado1', 'empleado2', 'empleado3', 'empleado4', 'empleado5', 'empleado6', 'empleado7', 'empleado8', 'empleado9', 'empleado10');
//echo $ejeEmpleados[0];
*/

?>


<div class="reporte" style="width: 6100px; float: left; display: inline-block">


    <!-- CABECERA DE EMPLEADOS -->
    <div class="reporte" style="width: 6100px; height: 65px; float: left">
        <div style="width: 500px; float: left;">

            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Categoría: </label>
                        <select name="categoria" id="categoria">
                            <option value="0">Todas las categorías</option>
                            <option value="1">Habilidades Soft</option>
                            <option value="2">Gestión</option>
                            <option value="3">Industria Oild</option>
                            <option value="4">Técnico</option>
                        </select>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Lugar de trabajo: </label>
                        <select name="lugar_trabajo" id="lugar_trabajo">
                            <option value="0">Todos los lugares de trabajo</option>
                            <option value="BO">Bolivia</option>
                            <option value="BUE">Buenos Aires</option>
                            <option value="CH">Chubut</option>
                            <option value="MZ">Mendoza</option>
                            <option value="NQ">Neuquén</option>
                            <option value="SC">Santa Cruz</option>
                        </select>

                    </div>
                </div>
            </div>



        </div>
        <div class="cuerpo" style="width: 5600px; float: left; height: 65px">
        <table id="tabla_empleados" style="table-layout: fixed;">

            <tr>
                <?php
                foreach($ejeEmpleados as $e){
                    ?>
                    <td class="colToggle<?php echo $e['LUGAR_TRABAJO']; ?>" style="width: 100px"><?php echo $e['LUGAR_TRABAJO']; ?></td>
                <?php

                }

                ?>
            </tr>

            <tr>
                <?php
                foreach($ejeEmpleados as $e){
                    ?>
                    <td class="colToggle<?php echo $e['LUGAR_TRABAJO']; ?>" style="width: 100px; height: 50px"><?php echo $e['APELLIDO'].' '.$e['NOMBRE']; ?></td>
                <?php

                }

                ?>
            </tr>


        </table>
        </div>

    </div>




    <!-- COLUMNA DE CURSOS -->
    <div id="div_tabla_cursos" style="float: left; width: 500px">
        <table id="tabla_cursos" style="table-layout: fixed; width: 500px; border-right: 0px">
            <?php
            foreach($ejeCursos as $c){
                ?>
                <tr class="rowToggle<?php echo $c['ID_CATEGORIA']; ?>">
                    <td style="width: 100px"><?php echo $c['CATEGORIA']; ?></td>
                    <td><?php echo Conexion::corta_palabra($c['NOMBRE'], 50); ?></td>
                </tr>
            <?php

            }

            ?>
        </table>

    </div>






    <!-- CUERPO DE LA TABLA -->
    <div class="cuerpo" style="float: left; margin-left: 500px">
        <table id="tabla_cuerpo" style="table-layout: fixed">

            <?php
            foreach($ejeCursos as $c){

                ?>
                <tr class="rowToggle<?php echo $c['ID_CATEGORIA']; ?>">
                    <?php

                    foreach($ejeEmpleados as $e){

                        ?>
                        <td class="colToggle<?php echo $e['LUGAR_TRABAJO']; ?>" style="width: 100px">
                            <?php


                            /*foreach($cuerpo as $cu){
                                if($cu['ID_EMPLEADO']==$e['ID_EMPLEADO'] && $cu['ID_CURSO']==$c['ID_CURSO']){
                                    if($cu['ESTADO']=='EVALUADO' || $cu['ESTADO']=='POST-EVALUADO'){
                                        $icon='green';
                                    }
                                    else if($cu['ESTADO']=='ASIGNADO' || $cu['ESTADO']=='COMUNICADO' || $cu['ESTADO']=='NOTIFICADO'){
                                        $icon='yellow';
                                    }
                                    else if($cu['ESTADO']=='CANCELADO' || $cu['ESTADO']=='SUSPENDIDO'){
                                        $icon='red';
                                    }
                                    ?>
                                    <a href="" title="<?php echo $cu['ESTADO']; ?>"><img src="public/img/<?php echo $icon; ?>-ok-icon.png" width="15px" height="15px"></a>
                                    <?php
                                    $coincidencia=1;
                                    break; //detiene el loop
                                }
                            }
                            if($coincidencia==1){
                                $coincidencia=0;
                            }
                            else{

                                ?>
                                <!-- la demora en renderizar la grilla se debe a la carga de las imagenes -->
                                <img src="public/img/document-icon.png" width="15px" height="15px">
                                <?php
                            }*/


                            //************** revisar **************************

                            $titulo="";
                            for($i=0; $i< sizeof($cuerpo); $i++){
                                if($cuerpo[$i]['ID_EMPLEADO']==$e['ID_EMPLEADO'] && $cuerpo[$i]['ID_CURSO']==$c['ID_CURSO']){

                                    $coincidencia=1;
                                    $cont=$i;
                                    while($cuerpo[$cont]['ID_EMPLEADO']==$e['ID_EMPLEADO'] && $cuerpo[$cont]['ID_CURSO']==$c['ID_CURSO']){

                                        if($cuerpo[$cont]['ESTADO']=='EVALUADO' || $cuerpo[$cont]['ESTADO']=='POST-EVALUADO'){
                                            $icon='green';
                                        }
                                        else if($cuerpo[$cont]['ESTADO']=='ASIGNADO' || $cuerpo[$cont]['ESTADO']=='COMUNICADO' || $cuerpo[$cont]['ESTADO']=='NOTIFICADO'){
                                            $icon='yellow';
                                        }
                                        else if($cuerpo[$cont]['ESTADO']=='CANCELADO' || $cuerpo[$cont]['ESTADO']=='SUSPENDIDO'){
                                            $icon='red';
                                        }

                                        //$titulo='Estado: '.$cuerpo[$cont]['ESTADO'].' Período: '.$cuerpo[$cont]['PERIODO'].' Fecha: '.$cuerpo[$cont]['FECHA_DESDE'];


                                        ?>
                                        <div style="display: inline-block" class="tooltip-target"><a href="#"><img src="public/img/<?php echo $icon; ?>-ok-icon.png" width="15px" height="15px"></a>
                                            <div class="example-content">
                                                <span style="display: block">Estado: <?php echo $cuerpo[$cont]['ESTADO'] ?></span>
                                                <span style="display: block">Período: <?php echo $cuerpo[$cont]['PERIODO'] ?></span>
                                                <span style="display: block">Fecha: <?php echo $cuerpo[$cont]['FECHA_DESDE'] ?></span>

                                            </div>
                                        </div>
                                        <?php


                                        $cont++;
                                    }
                                    break;


                                }

                            }

                            if($coincidencia==1){
                                $coincidencia=0;
                            }
                            else{

                                ?>
                                <img src="public/img/document-icon.png" width="15px" height="15px">
                            <?php
                            }

                            //--------------------- fin revisar -----------------------------------------------

                            ?>
                        </td>
                    <?php

                    }

                    ?>

                </tr>

            <?php


            }




            ?>

        </table>

    </div>




</div>








</body>


</html>



