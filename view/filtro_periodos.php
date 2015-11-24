

<div class="sixteen_column section">
    <div class="four column">
        <div class="column_content">
            <label>Período: </label><br/>
            <select name="filtro_periodo" id="filtro_periodo">
                <!--<option value="">Todos los períodos</option>-->
                <<?php
                foreach ($filtro_periodo as $per){
                    ?>
                    <option value="<?php echo $per["PERIODO"]; ?>"><?php echo $per["PERIODO"]; ?></option>
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

