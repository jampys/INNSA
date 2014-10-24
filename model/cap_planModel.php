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

    public static function getCapPlan(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $obj_user->executeQuery("select * from plan_capacitacion, cursos where plan_capacitacion.id_curso=cursos.id_curso");
        return $obj_user->fetchAll(); // retorna todos los cursos
    }

    public function getCapPlanById($id){
        $f=new Factory();
        $obj_user=$f->returnsQuery();

        $obj_user->executeQuery("select * from plan_capacitacion, cursos where plan_capacitacion.id_curso=cursos.id_curso");
        return $obj_user->fetchAll();
    }

    public static function getTemas($id){  //funcion usada para cargar dinamicamente select con los temas de la categoria seleccionada
        $f=new Factory();
        $obj_curso=$f->returnsQuery();
        $obj_curso->executeQuery("select * from temas where id_categoria=$id");
        return $obj_curso->fetchAll(); // retorna todos los cursos
    }



    function Curso($nro=0) //constructor... no hace nada
    {

    }

    // metodos que devuelven valores
    function getIdCurso()
    { return $this->id_curso;}

    function getNombre()
    { return $this->nombre;}

    function getDescripcion()
    { return $this->descripcion;}

    function getComentarios()
    { return $this->comentarios;}

    function getEntidad()
    { return $this->entidad;}

    function getIdTema()
    { return $this->id_tema;}

    // metodos que setean los valores
    function setIdCurso($val)
    { $this->id_curso=$val;}

    function setNombre($val)
    {  $this->nombre=$val;}

    function setDescripcion($val)
    {  $this->descripcion=$val;}

    function setComentarios($val)
    {  $this->comentarios=$val;}

    function setEntidad($val)
    {  $this->entidad=$val;}

    function setIdTema($val)
    {  $this->id_tema=$val;}



    public function updateCurso()
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cursos set nombre='$this->nombre', descripcion='$this->descripcion', comentarios='$this->comentarios', entidad='$this->entidad', id_tema=$this->id_tema where id_curso = $this->id_curso   ";
        $obj_user->executeQuery($query);
        //return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    public function insertCurso()	// inserta el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_curso=$f->returnsQuery();
        $query="insert into cursos(nombre, descripcion, comentarios, entidad, id_tema) values('$this->nombre', '$this->descripcion', '$this->comentarios', '$this->entidad' , $this->id_tema)";
        $obj_curso->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }
    function deleteCurso()	// elimina el cliente
    {
        $obj_cliente=new sQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }


}


?>