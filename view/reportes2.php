

<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "columnDefs": [
                { "width": "100px", "targets": 0 },
                { "width": "150px", "targets": 1 },
                { "width": "150px", "targets": 2 },
                { "width": "600px", "targets": 9 }
            ]
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );




        //filtros
        //$(document).on('change', '#periodo, #lugar_trabajo', function(){
        $('#periodo').on('change', function(){
            //alert($('#periodo').val());
            $('#reporte').load(
                'index.php',
                {   accion:"reportes",
                    operacion: "reportes2",
                    periodo:$('#periodo').val(),
                    filtro: 'filtro'
                }
            );

        });



    });

</script>


<h5>
    <a href="#" id="toggle-list">REPORTE: Cursos propuestos con asignación pendiente</a>
</h5>


<div class="sixteen_column section">
    <div class="four column">
        <div class="column_content">
            <label>Período: </label><br/>
            <select name="periodo" id="periodo">
                <option value="">Todos los períodos</option>
                <!--<option value="2014">2014</option>
                <option value="2015">2015</option>-->
                <?php
                foreach ($periodos as $per){
                    ?>
                    <option value="<?php echo $per["PERIODO"]; ?>"><?php echo $per["PERIODO"]; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="four column">
        <div class="column_content">

        </div>
    </div>

    <div class="four column">
        <div class="column_content">

        </div>
    </div>
    <div class="four column">
        <div class="column_content">

        </div>
    </div>

</div>





<div id="reporte">

    <?php include('view/reportesGrid2.php');  ?>

</div>



