<?php

class Reportes
{
    var $id_curso;
    var $nombre;
    var $descripcion;
    var $comentarios;
    var $entidad;
    var $id_tema;

    public static function getCursos(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$query="select * from cursos";
        $query="select ca.nombre CATEGORIA, ca.id_categoria, cu.id_curso, cu.nombre,".
                " (select count(cursos.id_curso) from cursos, temas, categorias where cursos.id_tema = temas.id_tema and temas.id_categoria = categorias.id_categoria and temas.id_categoria = ca.id_categoria) TOTAL".
                " from categorias ca, cursos cu, temas te".
                " where te.id_categoria = ca.id_categoria".
                " and cu.id_tema = te.id_tema";
        $obj_user->executeQuery($query);
        return $obj_user->fetchAll(); // retorna todos los cursos
    }

    public static function getEmpleadosActivos(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $obj_user->executeQuery("select * from empleados where activo=1 order by lugar_trabajo asc");
        return $obj_user->fetchAll(); // retorna todos los empleados
    }









    public function getEstadoAsignacion($id_empleado, $id_curso){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="select ap.estado ESTADO".
                " from asignacion_plan ap, plan_capacitacion pc, cursos cu, solicitud_capacitacion sc".
                " where ap.id_plan = pc.id_plan".
                " and pc.id_curso = cu.id_curso".
                " and ap.id_solicitud = sc.id_solicitud".
                " and sc.id_empleado = $id_empleado".
                " and cu.id_curso = $id_curso";
        $obj_user->executeQuery($query);
        if($obj_user->getAffect()>0){
            return $obj_user->fetchAll();
        }
        else{
            return 0;
        }

    }



    public function getEstadoAsignacion1(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="select sc.id_empleado, pc.id_curso, ap.estado".
                " from asignacion_plan ap, solicitud_capacitacion sc, plan_capacitacion pc".
                " where ap.id_solicitud = sc.id_solicitud".
                " and ap.id_plan = pc.id_plan";
        $obj_user->executeQuery($query);
        return $obj_user->fetchAll();

    }

    public static function getTemas($id){  //funcion usada para cargar dinamicamente select con los temas de la categoria seleccionada
        $f=new Factory();
        $obj_curso=$f->returnsQuery();
        $obj_curso->executeQuery("select * from temas where id_categoria=$id");
        return $obj_curso->fetchAll(); // retorna todos los cursos
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
        return $obj_user->getAffect(); // retorna todos los registros afectados

    }

    public function insertCurso()	// inserta el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_curso=$f->returnsQuery();
        $query="insert into cursos(nombre, descripcion, comentarios, entidad, id_tema) values('$this->nombre', '$this->descripcion', '$this->comentarios', '$this->entidad' , $this->id_tema)";
        $obj_curso->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_curso->getAffect(); // retorna todos los registros afectados

    }
    function deleteCurso()	// elimina el cliente
    {
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }


}


?>