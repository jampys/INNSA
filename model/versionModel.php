<?php


class Version
{
    var $sub_total_sin_viaticos;
    var $total_con_viaticos;
    var $total_reintegrable;
    var $total_aprobado;
    var $moneda;
    var $id_usuario;
    var $fecha_version;


    // metodos que devuelven valores
    function getSubTotalSinViaticos()
    { return floatval($this->sub_total_sin_viaticos);}

    function getTotalConViaticos()
    { return floatval($this->total_con_viaticos);}

    function getTotalReintegrable()
    { return floatval($this->total_reintegrable);}

    function getTotalAprobado()
    { return floatval($this->total_aprobado);}

    function getMoneda()
    { return $this->moneda;}

    function getIdUsuario()
    { return $this->id_usuario;}

    function getFechaVersion()
    { return $this->fecha_version;}


    // metodos que setean los valores
    function setSubTotalSinViaticos($val)
    { $this->sub_total_sin_viaticos=$val;}

    function setTotalConViaticos($val)
    {  $this->total_con_viaticos=$val;}

    function setTotalReintegrable($val)
    {  $this->total_reintegrable=$val;}

    function setTotalAprobado($val)
    {  $this->total_aprobado=$val;}

    function setMoneda($val)
    {  $this->moneda=$val;}

    function setIdUsuario($val)
    {  $this->id_usuario=$val;}

    function setFechaVersion($val)
    {  $this->fecha_version=$val;}


    public function insertVersion(){

        /*$f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into plan_maestro_version(fecha_version, id_usuario, subtotal_s_viaticos, total_c_viaticos, total_reintegrable, total_aprobado, moneda)".
            "values(SYSDATE, $this->id_usuario, $this->sub_total_sin_viaticos , $this->total_con_viaticos, $this->total_reintegrable, $this->total_aprobado, '$this->moneda')";
        $obj_emp->executeQuery($query);
        return $obj_emp->getAffect();*/

        $f=new Factory();
        $obj_ver=$f->returnsQuery();
        $query="insert into plan_maestro_version (fecha_version, id_usuario, subtotal_s_viaticos, total_c_viaticos, total_reintegrable, total_aprobado, moneda)".
                " values (SYSDATE, :id_usuario, :subtotal_s_viaticos, :total_c_viaticos, :total_reintegrable, :total_aprobado, :moneda)".
                " returning id_plan_maestro_version into :id";
        $topo=$obj_ver->dpParse($query);

        $obj_ver->dpBind(':id_usuario', $this->getIdUsuario());
        $obj_ver->dpBind(':subtotal_s_viaticos', floatval($this->getSubTotalSinViaticos()));
        $obj_ver->dpBind(':total_c_viaticos', $this->getTotalConViaticos());
        $obj_ver->dpBind(':total_reintegrable', $this->getTotalReintegrable());
        $obj_ver->dpBind(':total_aprobado', $this->getTotalAprobado());
        $obj_ver->dpBind(':moneda', $this->getMoneda());

        oci_bind_by_name($topo,':id', $id, -1, SQLT_INT);
        $obj_ver->dpExecute();
        return $id;

    }

    public function insertPlanCapacitacionVersion($id_plan_maestro_version){

        $f=new Factory();
        $obj_ver=$f->returnsQuery();
        $query="insert into plan_capacitacion_version (periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan, entidad, caracter_actividad, importe_total, cantidad_participantes, id_tipo_curso, id_programa, nro_actividad, porcentaje_reintegrable, id_plan, id_plan_maestro_version)".
                " select periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan, entidad, caracter_actividad, importe_total, cantidad_participantes, id_tipo_curso, id_programa, nro_actividad, porcentaje_reintegrable, id_plan, $id_plan_maestro_version from plan_capacitacion".
                " returning id_plan_version into :id";
        $topa=$obj_ver->dpParse($query);

        oci_bind_by_name($topa,':id', $id, -1, SQLT_INT);
        $obj_ver->dpExecute();
        //return $id;
        return $obj_ver->getAffect();

        /*$f=new Factory();
        $obj_ver=$f->returnsQuery();
        $query="insert into plan_capacitacion_version (periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan, entidad, caracter_actividad, importe_total, cantidad_participantes, id_tipo_curso, id_programa, nro_actividad, porcentaje_reintegrable, id_plan, id_plan_maestro_version)".
            " select periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan, entidad, caracter_actividad, importe_total, cantidad_participantes, id_tipo_curso, id_programa, nro_actividad, porcentaje_reintegrable, id_plan, $id_plan_maestro_version from plan_capacitacion";
        $obj_ver->dpParse($query);
        $obj_ver->dpExecute();
        return $obj_ver->getAffect();*/

    }





    public static function getEmpleados(){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        //$obj_emp->executeQuery("select * from empleados");
        $query="select em.*, di.nombre DIVISION, fu.nombre FUNCION from empleados em, division di, funciones fu".
                " where em.id_division = di.id_division (+) and em.funcion = fu.id_funcion (+)";
        $obj_emp->executeQuery($query);
        return $obj_emp->fetchAll(); // retorna todos los empleados
    }

    public function getEmpleadoById($id){
        /*
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        //$obj_emp->executeQuery("select * from empleados where id_empleado=$id");
        $obj_emp->executeQuery("select id_empleado, nombre, apellido, lugar_trabajo, n_legajo, empresa, funcion, division, to_char(fecha_ingreso,'DD/MM/YYYY') as fecha_ingreso, activo, email, cuil from empleados where id_empleado=$id");
        return $obj_emp->fetchAll(); */

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="select id_empleado, nombre, apellido, lugar_trabajo, n_legajo, empresa, funcion, to_char(fecha_ingreso,'DD/MM/YYYY')".
            " as fecha_ingreso, activo, email, cuil, id_division as division from empleados where id_empleado = :id";
        $obj_emp->dpParse($query);
        $obj_emp->dpBind(':id', $id);
        $obj_emp->dpExecute();
        return $obj_emp->fetchAll();
    }



    public function updateEmpleado(){
        /*
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$query="update empleados set apellido='$this->apellido', nombre='$this->nombre', lugar_trabajo='$this->lugar_trabajo', n_legajo=$this->n_legajo, empresa='$this->empresa', funcion='$this->funcion', categoria='$this->categoria', division='$this->division', fecha_ingreso=to_date('$this->fecha_ingreso','DD/MM/YYYY'), activo=$this->activo, email='$this->email', cuil='$this->cuil'  where id_empleado = $this->id_empleado";
        $query="update empleados set apellido='$this->apellido', nombre='$this->nombre', lugar_trabajo='$this->lugar_trabajo', n_legajo='$this->n_legajo', empresa='$this->empresa', funcion='$this->funcion', division='$this->division', fecha_ingreso=to_date('$this->fecha_ingreso','DD/MM/YYYY'), activo=$this->activo, email='$this->email', cuil='$this->cuil'  where id_empleado = $this->id_empleado";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect(); */

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="update empleados set apellido= :apellido, nombre= :nombre, lugar_trabajo= :lugar_trabajo, n_legajo= :n_legajo, empresa= :empresa, funcion= :funcion, ".
            " id_division= :division, fecha_ingreso=to_date(:fecha_ingreso,'DD/MM/YYYY'), activo= :activo, email= :email, cuil= :cuil where id_empleado = :id_empleado";
        $obj_emp->dpParse($query);

        $obj_emp->dpBind(':id_empleado', $this->id_empleado);
        $obj_emp->dpBind(':apellido', $this->apellido);
        $obj_emp->dpBind(':nombre', $this->nombre);
        $obj_emp->dpBind(':lugar_trabajo', $this->lugar_trabajo);
        $obj_emp->dpBind(':n_legajo', $this->n_legajo);
        $obj_emp->dpBind(':empresa', $this->empresa);
        $obj_emp->dpBind(':funcion', $this->funcion);
        $obj_emp->dpBind(':division', $this->id_division);
        $obj_emp->dpBind(':fecha_ingreso', $this->fecha_ingreso);
        $obj_emp->dpBind(':activo', $this->activo);
        $obj_emp->dpBind(':email', $this->email);
        $obj_emp->dpBind(':cuil', $this->cuil);

        $obj_emp->dpExecute();
        return $obj_emp->getAffect();

    }


    /*
    function delete(){
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query);
        return $obj_cliente->getAffect();
    }*/


    public function getDivisiones(){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="select * from division";
        $obj_emp->executeQuery($query);
        return $obj_emp->fetchAll(); // retorna todas las divisiones
    }


    public function availableLegajo($l, $e, $id){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $obj_user->executeQuery("select * from empleados where n_legajo = $l and empresa = $e and $id not in (select id_empleado from empleados where n_legajo = $l and id_empleado = $id)");

        $r=$obj_user->fetchAll();
        if($obj_user->getAffect()==0){
            $output = true;
        }
        else{
            $output = false;
        }
        return $output;
    }




}


?>