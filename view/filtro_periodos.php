

<div class="sixteen_column section">
    <div class="four column">
        <div class="column_content">
            <label>Período: </label><br/>
            <select name="filtro_periodo" id="filtro_periodo">
                <!--<option value="">Todos los períodos</option>-->
                <<?php
                foreach ($filtro_periodo as $per){
                    ?>
                    <!-- trae los periodos que tienen las solicitudes y capacitaciones... y selecciona de ellos el periodo vigente -->
                    <option value="<?php echo $per["PERIODO"]; ?>" <?php if ($per["PERIODO"] == date('Y') ) echo 'selected' ; ?>  ><?php echo $per["PERIODO"]; ?>
                <?php
                }
                ?>
            </select>
        </div>
    </div>

<div class="twelve column">
    <div class="column_content">

    </div>
</div>


</div>




