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

    public function insertEmpleado(){
        /*
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into empleados(apellido, nombre, lugar_trabajo, n_legajo, empresa, funcion, division, fecha_ingreso, activo, email, cuil)".
            "values('$this->apellido', '$this->nombre', '$this->lugar_trabajo' , '$this->n_legajo', '$this->empresa', '$this->funcion', '$this->division', to_date('$this->fecha_ingreso','DD/MM/YYYY'), $this->activo, '$this->email', '$this->cuil')";
        $obj_emp->executeQuery($query);
        return $obj_emp->getAffect(); */

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into empleados (apellido, nombre, lugar_trabajo, n_legajo, empresa, funcion, id_division, fecha_ingreso, activo, email, cuil)".
            " values(:apellido, :nombre, :lugar_trabajo, :n_legajo, :empresa, :funcion, :division, to_date(:fecha_ingreso,'DD/MM/YYYY'), :activo, :email, :cuil)";
        $obj_emp->dpParse($query);

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



}


?>