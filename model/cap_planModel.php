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

    public static function getCapPlan(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $obj_user->executeQuery("select * from plan_capacitacion, cursos where plan_capacitacion.id_curso=cursos.id_curso");
        return $obj_user->fetchAll(); // retorna todos los cursos
    }

    public function getCapPlanById($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();

        $obj_cp->executeQuery("select * from plan_capacitacion, cursos where plan_capacitacion.id_curso=cursos.id_curso and plan_capacitacion.id_plan=$id");
        return $obj_cp->fetchAll();
    }

    public static function getCursos($term){  //funcion usada para cargar dinamicamente select con los temas de la categoria seleccionada
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        //$obj_cp->executeQuery("select * from cursos");
        //$query="select * from cursos where nombre like '%".$term."%'";
        $query="select * from cursos where nombre like UPPER ('%".$term."%')";
        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll(); // retorna todos los cursos
    }



    function Curso($nro=0) //constructor... no hace nada
    {

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



    public function updateCapPlan()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update plan_capacitacion set periodo=$this->periodo, objetivo='$this->objetivo', modalidad='$this->modalidad', fecha_desde=TO_DATE('$this->fecha_desde','DD/MM/YYYY'), fecha_hasta=TO_DATE('$this->fecha_hasta','DD/MM/YYYY'), duracion=$this->duracion, unidad='$this->unidad', prioridad=$this->prioridad, estado='$this->estado', importe=$this->importe, moneda='$this->moneda', tipo_cambio=$this->tipo_cambio, forma_pago='$this->forma_pago', forma_financiacion=$this->forma_financiacion, profesor_1='$this->profesor_1', profesor_2='$this->profesor_2', comentarios_plan='$this->comentarios' where id_plan = $this->id_plan";
        $obj_cp->executeQuery($query);
        //return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    public function insertCapPlan()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="insert into plan_capacitacion (id_curso, periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan)".
        "values($this->id_curso, $this->periodo, '$this->objetivo', '$this->modalidad', TO_DATE('$this->fecha_desde','DD/MM/YYYY'), TO_DATE('$this->fecha_hasta','DD/MM/YYYY'), $this->duracion , '$this->unidad', $this->prioridad, '$this->estado', $this->importe, '$this->moneda', $this->tipo_cambio, '$this->forma_pago', $this->forma_financiacion, '$this->profesor_1', '$this->profesor_2', '$this->comentarios')";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }
    function deleteCurso()	// elimina el cliente
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cp->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cp->getAffect(); // retorna todos los registros afectados

    }


}


?>