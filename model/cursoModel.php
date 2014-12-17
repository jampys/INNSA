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
        //$obj_user->executeQuery("select * from cursos");
        $obj_user->executeQuery("select cu.id_curso, cu.nombre nombre_curso, ca.nombre nombre_categoria, te.nombre nombre_tema from cursos cu, temas te, categorias ca where cu.id_tema = te.id_tema and te.id_categoria = ca.id_categoria ");
        return $obj_user->fetchAll();
    }

    public function getCursoById($id){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        /*$obj_user->executeQuery("select cu.nombre NOMBRE_CURSO, cu.descripcion DESCRIPCION_CURSO, cu.comentarios COMENTARIOS_CURSO, cu.entidad ENTIDAD_CURSO, ca.ID_CATEGORIA ID_CATEGORIA, te.ID_TEMA ID_TEMA".
                                  "from cursos cu, categorias ca, temas te".
                                  "where cu.id_tema=te.id_tema".
                                  "and te.id_categoria=ca.id_categoria".
                                  "and cu.id_curso=$id"); */
        $obj_user->executeQuery("select cu.nombre NOMBRE_CURSO, cu.descripcion DESCRIPCION_CURSO, cu.comentarios COMENTARIOS_CURSO, cu.entidad ENTIDAD_CURSO, te.id_categoria ID_CATEGORIA, cu.id_tema ID_TEMA from cursos cu, temas te where cu.id_tema=te.id_tema and cu.id_curso=$id");
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



    public function updateCurso(){
        /*
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cursos set nombre='$this->nombre', descripcion='$this->descripcion', comentarios='$this->comentarios', entidad='$this->entidad', id_tema=$this->id_tema where id_curso = $this->id_curso   ";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect(); */

        $f=new Factory();
        $obj_curso=$f->returnsQuery();
        $query="update cursos set nombre = :nombre, descripcion = :descripcion, comentarios = :comentarios, entidad = :entidad, id_tema = :id_tema where id_curso = :id_curso";
        $obj_curso->dpParse($query);

        $obj_curso->dpBind(':nombre', $this->nombre);
        $obj_curso->dpBind(':descripcion', $this->descripcion);
        $obj_curso->dpBind(':comentarios', $this->comentarios);
        $obj_curso->dpBind(':entidad', $this->entidad);
        $obj_curso->dpBind(':id_tema', $this->id_tema);
        $obj_curso->dpBind(':id_curso', $this->id_curso);

        $obj_curso->dpExecute();
        return $obj_curso->getAffect();
    }

    public function insertCurso(){
        /*
        $f=new Factory();
        $obj_curso=$f->returnsQuery();
        $query="insert into cursos(nombre, descripcion, comentarios, entidad, id_tema) values('$this->nombre', '$this->descripcion', '$this->comentarios', '$this->entidad' , $this->id_tema)";
        $obj_curso->executeQuery($query);
        return $obj_curso->getAffect(); */

        $f=new Factory();
        $obj_curso=$f->returnsQuery();
        $query="insert into cursos(nombre, descripcion, comentarios, entidad, id_tema) values(:nombre, :descripcion, :comentarios, :entidad, :id_tema)";
        $obj_curso->dpParse($query);

        $obj_curso->dpBind(':nombre', $this->nombre);
        $obj_curso->dpBind(':descripcion', $this->descripcion);
        $obj_curso->dpBind(':comentarios', $this->comentarios);
        $obj_curso->dpBind(':entidad', $this->entidad);
        $obj_curso->dpBind(':id_tema', $this->id_tema);

        $obj_curso->dpExecute();
        return $obj_curso->getAffect();
    }

    /*
    function deleteCurso(){
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query);
        return $obj_cliente->getAffect();
    }
    */


}


?>