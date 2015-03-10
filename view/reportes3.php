

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
        $('#periodo, #lugar_trabajo').on('change', function(){
            //alert($('#periodo').val());
            $('#reporte').load(
                'index.php',
                {   accion:"reportes",
                    operacion: "reportes3",
                    periodo:$('#periodo').val(),
                    lugar_trabajo: $('#lugar_trabajo').val(),
                    filtro: 'filtro'
                }
            );

        });



    });

</script>




<div class="sixteen_column section">
    <div class="four column">
        <div class="column_content">
            <label>Período: </label><br/>
            <select name="periodo" id="periodo">
                <option value="">Todos los períodos</option>
                <<?php
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
            <label>Lugar de trabajo: </label>
            <select name="lugar_trabajo" id="lugar_trabajo">
                <option value="">Todos los lugares de trabajo</option>
                <option value="BO">Bolivia</option>
                <option value="BUE">Buenos Aires</option>
                <option value="CH">Chubut</option>
                <option value="MZ">Mendoza</option>
                <option value="NQ">Neuquén</option>
                <option value="SC">Santa Cruz</option>
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

</div>





<div id="reporte">

    <?php include('view/reportesGrid3.php');  ?>

</div>



