<?php

class Cap_Plan
{
    var $id_plan;
    var $id_curso;
    var $periodo;
    var $objetivo;
    var $modalidad;
    var $fecha_desde;
    var $fecha_hasta;
    var $duracion;
    var $unidad;
    var $prioridad;
    var $estado;
    var $importe;
    var $moneda;
    var $tipo_cambio;
    var $cantidad;
    var $forma_pago;
    var $forma_financiacion;
    var $profesor_1;
    var $profesor_2;
    var $comentarios;
    var $entidad;

    public static function getCapPlan(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$obj_user->executeQuery("select * from plan_capacitacion, cursos where plan_capacitacion.id_curso=cursos.id_curso");
        $query="select pc.id_plan, cu.nombre, pc.periodo, pc.fecha_desde, pc.fecha_hasta, pc.duracion, pc.unidad, pc.estado, pc.importe, pc.moneda, pc.entidad, (select count(*)from asignacion_plan ap where ap.id_plan = pc.id_plan) as cantidad".
                " from plan_capacitacion pc, cursos cu".
                " where pc.id_curso=cu.id_curso";
        $obj_user->executeQuery($query);
        return $obj_user->fetchAll();
    }

    public function getCapPlanById($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        //$obj_cp->executeQuery("select * from plan_capacitacion, cursos where plan_capacitacion.id_curso=cursos.id_curso and plan_capacitacion.id_plan=$id");
        $obj_cp->executeQuery("select pc.id_plan, pc.id_curso, pc.periodo, pc.objetivo, pc.modalidad, to_char(pc.fecha_desde,'DD/MM/YYYY') as fecha_desde, to_char(pc.fecha_hasta,'DD/MM/YYYY') as fecha_hasta, pc.duracion, pc.unidad, pc.prioridad, pc.estado, pc. importe, pc.moneda, pc.tipo_cambio, pc.forma_pago, pc.forma_financiacion, pc.profesor_1, pc.profesor_2, pc.comentarios_plan, pc.entidad entidad_plan, cu.* from plan_capacitacion pc, cursos cu where pc.id_curso=cu.id_curso and pc.id_plan=$id");
        return $obj_cp->fetchAll();
    }

    public static function getCursos($term, $target){
        /*Si target es igual a ALL, traigo todos los cursos que contengan la cadena term
         *Si target es igual a BYPERIODO traigo todos cursos que contengan la cadena term, y ademas si tienen
         * un plan en el periodo vigente o superior => que lo muestre
         */
        if($target=='ALL'){
            $query="select * from cursos where nombre like UPPER ('%".$term."%')";
        }
        else if($target=='BYPERIODO'){
            $query="select cu.id_curso, cu.nombre, pc.periodo, pc.fecha_desde, pc.modalidad, pc.entidad".
                " from cursos cu".
                " left join plan_capacitacion pc".
                " on cu.id_curso = pc.id_curso and pc.periodo >=".date('Y').
                " where cu.nombre like UPPER ('%".$term."%')";
        }
        $f=new Factory();
        $obj_cp=$f->returnsQuery();

        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll(); // retorna todos los cursos
    }



    // metodos que devuelven valores
    function getIdPlan()
    { return $this->id_plan;}

    function getIdCurso()
    { return $this->id_curso;}

    function getPeriodo()
    { return $this->periodo;}

    function getObjetivo()
    { return $this->objetivo;}

    function getModalidad()
    { return $this->modalidad;}

    function getFechaDesde()
    { return $this->fecha_desde;}

    function getFechaHasta()
    { return $this->fecha_hasta;}

    function getDuracion()
    { return $this->duracion;}

    function getUnidad()
    { return $this->unidad;}

    function getPrioridad()
    { return $this->prioridad;}

    function getEstado()
    { return $this->estado;}

    function getImporte()
    { return $this->importe;}

    function getMoneda()
    { return $this->moneda;}

    function getTipoCambio()
    { return $this->tipo_cambio;}

    function getCantidad()
    { return $this->cantidad;}

    function getFormaPago()
    { return $this->forma_pago;}

    function getFormaFinanciacion()
    { return $this->forma_financiacion;}

    function getProfesor1()
    { return $this->profesor_1;}

    function getProfesor2()
    { return $this->profesor_2;}

    function getComentarios()
    { return $this->comentarios;}

    function getEntidad()
    { return $this->entidad;}

    // metodos que setean los valores
    function setIdPlan($val)
    { $this->id_plan=$val;}

    function setIdCurso($val)
    {  $this->id_curso=$val;}

    function setPeriodo($val)
    {  $this->periodo=$val;}

    function setObjetivo($val)
    {  $this->objetivo=$val;}

    function setModalidad($val)
    {  $this->modalidad=$val;}

    function setFechaDesde($val)
    {  $this->fecha_desde=$val;}

    function setFechaHasta($val)
    {  $this->fecha_hasta=$val;}

    function setDuracion($val)
    {  $this->duracion=$val;}

    function setUnidad($val)
    {  $this->unidad=$val;}

    function setPrioridad($val)
    {  $this->prioridad=$val;}

    function setEstado($val)
    {  $this->estado=$val;}

    function setImporte($val)
    {  $this->importe=$val;}

    function setMoneda($val)
    {  $this->moneda=$val;}

    function setTipoCambio($val)
    {  $this->tipo_cambio=$val;}

    function setCantidad($val)
    {  $this->cantidad=$val;}

    function setFormaPago($val)
    {  $this->forma_pago=$val;}

    function setFormaFinanciacion($val)
    {  $this->forma_financiacion=$val;}

    function setProfesor1($val)
    {  $this->profesor_1=$val;}

    function setProfesor2($val)
    {  $this->profesor_2=$val;}

    function setComentarios($val)
    {  $this->comentarios=$val;}

    function setEntidad($val)
    {  $this->entidad=$val;}



    public function updateCapPlan(){
        /*
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update plan_capacitacion set periodo=$this->periodo, objetivo='$this->objetivo', modalidad='$this->modalidad', fecha_desde=TO_DATE('$this->fecha_desde','DD/MM/YYYY'), fecha_hasta=TO_DATE('$this->fecha_hasta','DD/MM/YYYY'), duracion=$this->duracion, unidad='$this->unidad', prioridad=$this->prioridad, estado='$this->estado', importe=$this->importe, moneda='$this->moneda', tipo_cambio=$this->tipo_cambio, forma_pago='$this->forma_pago', forma_financiacion='$this->forma_financiacion', profesor_1='$this->profesor_1', profesor_2='$this->profesor_2', comentarios_plan='$this->comentarios' where id_plan = $this->id_plan";
        $obj_cp->executeQuery($query);
        return $obj_cp->getAffect(); */

        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update plan_capacitacion set periodo = :periodo, objetivo = :objetivo, modalidad = :modalidad, fecha_desde = TO_DATE( :fecha_desde,'DD/MM/YYYY'), fecha_hasta = TO_DATE( :fecha_hasta,'DD/MM/YYYY'),".
                " duracion = :duracion, unidad = :unidad, prioridad = :prioridad, estado = :estado, importe = :importe, moneda = :moneda, tipo_cambio = :tipo_cambio, forma_pago = :forma_pago,".
                " forma_financiacion = :forma_financiacion, profesor_1 = :profesor_1, profesor_2 = :profesor_2, comentarios_plan = :comentarios, entidad = :entidad where id_plan = :id_plan";
        $obj_cp->dpParse($query);

        $obj_cp->dpBind(':periodo', $this->periodo);
        $obj_cp->dpBind(':objetivo', $this->objetivo);
        $obj_cp->dpBind(':modalidad', $this->modalidad);
        $obj_cp->dpBind(':fecha_desde', $this->fecha_desde);
        $obj_cp->dpBind(':fecha_hasta', $this->fecha_hasta);
        $obj_cp->dpBind(':duracion', $this->duracion);
        $obj_cp->dpBind(':unidad', $this->unidad);
        $obj_cp->dpBind(':prioridad', $this->prioridad);
        $obj_cp->dpBind(':estado', $this->estado);
        $obj_cp->dpBind(':importe', $this->importe);
        $obj_cp->dpBind(':moneda', $this->moneda);
        $obj_cp->dpBind(':tipo_cambio', $this->tipo_cambio);
        $obj_cp->dpBind(':forma_pago', $this->forma_pago);
        $obj_cp->dpBind(':forma_financiacion', $this->forma_financiacion);
        $obj_cp->dpBind(':profesor_1', $this->profesor_1);
        $obj_cp->dpBind(':profesor_2', $this->profesor_2);
        $obj_cp->dpBind(':comentarios', $this->comentarios);
        $obj_cp->dpBind(':entidad', $this->entidad);
        $obj_cp->dpBind(':id_plan', $this->id_plan);

        $obj_cp->dpExecute();
        return $obj_cp->getAffect();
    }

    public function insertCapPlan(){

        /*
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="insert into plan_capacitacion (id_curso, periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan)".
        "values($this->id_curso, $this->periodo, '$this->objetivo', '$this->modalidad', TO_DATE('$this->fecha_desde','DD/MM/YYYY'), TO_DATE('$this->fecha_hasta','DD/MM/YYYY'), $this->duracion , '$this->unidad', $this->prioridad, '$this->estado', $this->importe, '$this->moneda', $this->tipo_cambio, '$this->forma_pago', '$this->forma_financiacion', '$this->profesor_1', '$this->profesor_2', '$this->comentarios')";
        $obj_cp->executeQuery($query);
        return $obj_cp->getAffect(); */

        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="insert into plan_capacitacion (id_curso, periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan, entidad)".
            " values(:id_curso, :periodo, :objetivo, :modalidad, TO_DATE(:fecha_desde,'DD/MM/YYYY'), TO_DATE(:fecha_hasta,'DD/MM/YYYY'), :duracion , :unidad, :prioridad, :estado, :importe, :moneda, :tipo_cambio, :forma_pago, :forma_financiacion, :profesor_1, :profesor_2, :comentarios, :entidad)";
        $obj_cp->dpParse($query);

        $obj_cp->dpBind(':id_curso', $this->id_curso);
        $obj_cp->dpBind(':periodo', $this->periodo);
        $obj_cp->dpBind(':objetivo', $this->objetivo);
        $obj_cp->dpBind(':modalidad', $this->modalidad);
        $obj_cp->dpBind(':fecha_desde', $this->fecha_desde);
        $obj_cp->dpBind(':fecha_hasta', $this->fecha_hasta);
        $obj_cp->dpBind(':duracion', $this->duracion);
        $obj_cp->dpBind(':unidad', $this->unidad);
        $obj_cp->dpBind(':prioridad', $this->prioridad);
        $obj_cp->dpBind(':estado', $this->estado);
        $obj_cp->dpBind(':importe', $this->importe);
        $obj_cp->dpBind(':moneda', $this->moneda);
        $obj_cp->dpBind(':tipo_cambio', $this->tipo_cambio);
        $obj_cp->dpBind(':forma_pago', $this->forma_pago);
        $obj_cp->dpBind(':forma_financiacion', $this->forma_financiacion);
        $obj_cp->dpBind(':profesor_1', $this->profesor_1);
        $obj_cp->dpBind(':profesor_2', $this->profesor_2);
        $obj_cp->dpBind(':comentarios', $this->comentarios);
        $obj_cp->dpBind(':entidad', $this->entidad);

        $obj_cp->dpExecute();
        return $obj_cp->getAffect();
    }


    public function getEmpleadosByPlan($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="select ap.id_asignacion, sc.id_solicitud, sc.estado, em.apellido, em.nombre, ap.comentarios, ap.viaticos".
                " from empleados em, solicitud_capacitacion sc, propuestas pro, cursos cu, plan_capacitacion pc, asignacion_plan ap".
                " where pro.id_solicitud = sc.id_solicitud".
                " and sc.id_empleado = em.id_empleado".
                " and ap.id_solicitud (+) = sc.id_solicitud".
                " and pro.id_curso = cu.id_curso".
                " and pc.id_curso = cu.id_curso".
                " and pc.id_plan = $id";
        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll();
    }




}


?>