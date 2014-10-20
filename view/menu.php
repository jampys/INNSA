			<div class="boton">
			<a href="" class="url_boton" title="Recursos">Recursos</a>
			</div>
            <div class="boton">
			<a href="" class="url_boton" title="Cursos" id="menu_2">Cursos</a>
			</div>
            <div class="boton">
			<a href="" class="url_boton" title="Asignacion plan" id="menu_3">Asignacion plan</a>
			</div>
            <div class="boton">
			<a href="" class="url_boton" title="Evaluacion plan" id="menu_4">Evaluacion plan</a>
			</div>
            <div class="boton">
			<a href="" class="url_boton" title="Post evaluacion plan" id="menu_5">Post evaluacion plan</a>
			</div>
            <!-- Opciones de menu solo para usuario administrador -->
            <?php
            if($_SESSION['ACCESSLEVEL']==1){
                ?>
                <div class="boton">
                    <a href="index.php?accion=user" class="url_boton" title="Usuarios">Usuarios</a>
                </div>
                <div class="boton">
                    <a href="" class="url_boton" title="Alarmas">Alarmas</a>
                </div>

                <?php
            }
            ?>
