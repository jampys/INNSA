<?php


class Categoria
{
    var $id_categoria;
    var $nombre;
    var $descripcion;
    var $estado;

    //Metodo ya implementado en cursoModel. Eliminarlo de ahi y llamar a este en el cursoController
    public function getCategorias(){
        $f=new Factory();
        $obj_cat=$f->returnsQuery();
        $query="select * from categorias";
        $obj_cat->executeQuery($query);
        return $obj_cat->fetchAll();
    }

    public function getCategoriaById($id){
    $f=new Factory();
    $obj_cat=$f->returnsQuery();
    $query="select * from categorias where id_categoria = :id";
    $obj_cat->dpParse($query);
    $obj_cat->dpBind(':id', $id);
    $obj_cat->dpExecute();
    return $obj_cat->fetchAll();
    }

    public function getTemasByCategoria($id){
        $f=new Factory();
        $obj_cat=$f->returnsQuery();
        $query="select * from temas where id_categoria = :id";
        $obj_cat->dpParse($query);
        $obj_cat->dpBind(':id', $id);
        $obj_cat->dpExecute();
        return $obj_cat->fetchAll();
    }



    // metodos que devuelven valores
    function getIdCategoria()
    { return $this->id_categoria;}

    function getNombre()
    { return $this->nombre;}

    function getDescripcion()
    { return $this->descripcion;}

    function getEstado()
    { return $this->estado;}


    // metodos que setean los valores
    function setIdCategoria($val)
    { $this->id_categoria=$val;}

    function setNombre($val)
    {  $this->nombre=$val;}

    function setDescripcion($val)
    {  $this->descripcion=$val;}

    function setEstado($val)
    {  $this->estado=$val;}



    public function updateCategoria(){

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="update categorias set nombre= :nombre, descripcion= :descripcion, estado= :estado where id_categoria = :id_categoria";
        $obj_emp->dpParse($query);

        $obj_emp->dpBind(':nombre', $this->getNombre());
        $obj_emp->dpBind(':descripcion', $this->getDescripcion());
        $obj_emp->dpBind(':estado', $this->getEstado());
        $obj_emp->dpBind(':id_categoria', $this->getIdCategoria());

        $obj_emp->dpExecute();
        return $obj_emp->getAffect();

    }

    public function insertCategoria(){

        $f=new Factory();
        $obj_sc=$f->returnsQuery();
        $query="insert into categorias (nombre, descripcion, estado)".
            " values(:nombre, :descripcion, :estado)".
            " returning id_categoria into :id";
        $topo=$obj_sc->dpParse($query);

        $obj_sc->dpBind(':nombre', $this->getNombre());
        $obj_sc->dpBind(':descripcion', $this->getDescripcion());
        $obj_sc->dpBind(':estado', $this->getEstado());

        //Se asigna a la variable $id el valor :id devuelto por la consulta, si le saco el parametro $obj_sc da error
        oci_bind_by_name($topo,':id', $id, -1, SQLT_INT);
        $obj_sc->dpExecute();
        return $id;

    }



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


class Tema{

    var $id_tema;
    var $id_categoria;
    var $nombre;
    var $estado;

    // metodos que devuelven valores
    function getIdTema()
    { return $this->id_tema;}

    function getIdCategoria()
    { return $this->id_categoria;}

    function getNombre()
    { return $this->nombre;}


    function getEstado()
    { return $this->estado;}


    // metodos que setean los valores
    function setIdTema($val)
    { $this->id_tema=$val;}

    function setIdCategoria($val)
    { $this->id_categoria=$val;}

    function setNombre($val)
    {  $this->nombre=$val;}

    function setEstado($val)
    {  $this->estado=$val;}


    public function updateTema(){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="update temas set nombre= :nombre, estado= :estado where id_tema = :id_tema";
        $obj_emp->dpParse($query);

        $obj_emp->dpBind(':nombre', $this->getNombre());
        $obj_emp->dpBind(':estado', $this->getEstado());
        $obj_emp->dpBind(':id_tema', $this->getIdTema());

        $obj_emp->dpExecute();
        return $obj_emp->getAffect();

    }

    public function insertTema(){

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into temas (id_categoria, nombre, estado) values(:id_categoria, :nombre, :estado)";
        $obj_emp->dpParse($query);

        $obj_emp->dpBind(':id_categoria', $this->getIdCategoria());
        $obj_emp->dpBind(':nombre', $this->getNombre());
        $obj_emp->dpBind(':estado', $this->getEstado());

        $obj_emp->dpExecute();
        return $obj_emp->getAffect();
    }



}


?>