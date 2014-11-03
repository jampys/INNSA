<?php

class Cap_Solic
{
    var $id_asignacion;
    var $objetivo;
    var $comentarios;
    var $viaticos;
    var $id_solicitud;
    var $id_plan;


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

    public static function getPlanes($term){  //funcion usada para autocompletar planes
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        //$query="select * from cursos where nombre like UPPER ('%".$term."%')";
        $query="select * from plan_capacitacion, cursos where plan_capacitacion.id_curso = cursos.id_curso and nombre like UPPER ('%".$term."%')";
        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll(); // retorna todos los cursos
    }



    function Curso($nro=0) //constructor... no hace nada
    {

    }

    // metodos que devuelven valores
    function getIdAsignacion()
    { return $this->id_asignacion;}

    function getObjetivo()
    { return $this->objetivo;}

    function getComentarios()
    { return $this->comentarios;}

    function getViaticos()
    { return $this->viaticos;}

    function getIdSolicitud()
    { return $this->id_solicitud;}

    function getIdPlan()
    { return $this->id_plan;}



    // metodos que setean los valores
    function setIdAsignacion($val)
    { $this->id_asignacion=$val;}

    function setObjetivo($val)
    {  $this->objetivo=$val;}

    function setComentarios($val)
    {  $this->comentarios=$val;}

    function setViaticos($val)
    {  $this->viaticos=$val;}

    function setIdSolicitud($val)
    {  $this->id_solicitud=$val;}

    function setIdPlan($val)
    {  $this->id_plan=$val;}



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


    public function insertPlanes()
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "insert into asignacion_plan (objetivo, comentarios, viaticos, id_plan) values('$this->objetivo', '$this->comentarios', $this->viaticos, $this->id_plan)";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }



}


?>