<?php

class Curso
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
        $obj_user->executeQuery("select * from cursos");
        return $obj_user->fetchAll(); // retorna todos los cursos
    }

    public function getCursoById($id){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$obj_user->executeQuery("select * from usuarios where id_usuario=$id");
        $obj_user->executeQuery("select * from usuarios, perfiles where usuarios.id_perfil = perfiles.id_perfil and id_usuario=$id");
        return $obj_user->fetchAll(); // retorna todos los clientes
    }

    public static function getTemas($id){
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



    public function updateCurso()	// actualiza el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update usuarios set login='$this->login', password='$this->password', id_perfil=$this->id_perfil where id_usuario = $this->id_usuario   ";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    public function insertCurso()	// inserta el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$query="insert into usuarios(id_usuario, login, password, fecha_alta, id_perfil, habilitado) values(7, '$this->login', '$this->password', TO_DATE('$this->fecha_alta','DD/MM/YYYY'), $this->id_perfil , 1)";
        $query="insert into usuarios(login, password, fecha_alta, id_perfil, habilitado) values('$this->login', '$this->password', TO_DATE('$this->fecha_alta','DD/MM/YYYY'), $this->id_perfil , 1)";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
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