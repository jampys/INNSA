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



class EntidadCapacitadora{


    var $id_entidad_capacitadora;
    var $nombre;
    var $estado;

    // metodos que devuelven valores
    function getIdEntidadCapacitadora()
    { return $this->id_entidad_capacitadora;}

    function getNombre()
    { return $this->nombre;}

    function getEstado()
    { return $this->estado;}


    // metodos que setean los valores
    function setIdEntidadCapacitadora($val)
    { $this->id_entidad_capacitadora=$val;}

    function setNombre($val)
    {  $this->nombre=$val;}

    function setEstado($val)
    {  $this->estado=$val;}


    public function getEntidadesCapacitadoras(){
        $f=new Factory();
        $obj_ec=$f->returnsQuery();
        $query="select * from entidades_capacitadoras";
        $obj_ec->executeQuery($query);
        return $obj_ec->fetchAll();
    }

    public function getEntidadById($id){
        $f=new Factory();
        $obj_cat=$f->returnsQuery();
        $query="select * from entidades_capacitadoras where id_entidad_capacitadora = :id";
        $obj_cat->dpParse($query);
        $obj_cat->dpBind(':id', $id);
        $obj_cat->dpExecute();
        return $obj_cat->fetchAll();
    }


    public function updateEntidad(){
        $f=new Factory();
        $obj_ec=$f->returnsQuery();
        $query="update entidades_capacitadoras set nombre= :nombre, estado= :estado where id_entidad_capacitadora = :id_entidad_capacitadora";
        $obj_ec->dpParse($query);

        $obj_ec->dpBind(':nombre', $this->getNombre());
        $obj_ec->dpBind(':estado', $this->getEstado());
        $obj_ec->dpBind(':id_entidad_capacitadora', $this->getIdEntidadCapacitadora());

        $obj_ec->dpExecute();
        return $obj_ec->getAffect();

    }

    public function insertEntidad(){

        $f=new Factory();
        $obj_ec=$f->returnsQuery();
        $query="insert into entidades_capacitadoras(nombre, estado) values(:nombre, :estado)";
        $obj_ec->dpParse($query);

        $obj_ec->dpBind(':nombre', $this->getNombre());
        $obj_ec->dpBind(':estado', $this->getEstado());

        $obj_ec->dpExecute();
        return $obj_ec->getAffect();
    }


}


class Funcion{



    var $id_funcion;
    var $nombre;
    var $estado;
    var $id_division;

    // metodos que devuelven valores
    function getIdFuncion()
    { return $this->id_funcion;}

    function getNombre()
    { return $this->nombre;}

    function getEstado()
    { return $this->estado;}

    function getIdDivision()
    { return $this->id_division;}


    // metodos que setean los valores
    function setIdFuncion($val)
    { $this->id_funcion=$val;}

    function setNombre($val)
    {  $this->nombre=$val;}

    function setEstado($val)
    {  $this->estado=$val;}

    function setIdDivision($val)
    {  $this->id_division=$val;}


    public function getFunciones($id){
        $f=new Factory();
        $obj_fn=$f->returnsQuery();
        $query="select * from funciones where id_division = $id";
        $obj_fn->executeQuery($query);
        return $obj_fn->fetchAll();
    }

    public function getEntidadById($id){
        $f=new Factory();
        $obj_cat=$f->returnsQuery();
        $query="select * from entidades_capacitadoras where id_entidad_capacitadora = :id";
        $obj_cat->dpParse($query);
        $obj_cat->dpBind(':id', $id);
        $obj_cat->dpExecute();
        return $obj_cat->fetchAll();
    }


    public function updateEntidad(){
        $f=new Factory();
        $obj_ec=$f->returnsQuery();
        $query="update entidades_capacitadoras set nombre= :nombre, estado= :estado where id_entidad_capacitadora = :id_entidad_capacitadora";
        $obj_ec->dpParse($query);

        $obj_ec->dpBind(':nombre', $this->getNombre());
        $obj_ec->dpBind(':estado', $this->getEstado());
        $obj_ec->dpBind(':id_entidad_capacitadora', $this->getIdEntidadCapacitadora());

        $obj_ec->dpExecute();
        return $obj_ec->getAffect();

    }

    public function insertEntidad(){

        $f=new Factory();
        $obj_ec=$f->returnsQuery();
        $query="insert into entidades_capacitadoras(nombre, estado) values(:nombre, :estado)";
        $obj_ec->dpParse($query);

        $obj_ec->dpBind(':nombre', $this->getNombre());
        $obj_ec->dpBind(':estado', $this->getEstado());

        $obj_ec->dpExecute();
        return $obj_ec->getAffect();
    }


}



?>