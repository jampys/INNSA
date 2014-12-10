

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
                    operacion: "filtrosReportes",
                    periodo:$('#periodo').val(),
                    lugar_trabajo: $('#lugar_trabajo').val()
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
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
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

    <?php include('view/reportesGrid.php');  ?>

</div>



