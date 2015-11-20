<?php


class Version
{
    var $sub_total_sin_viaticos;
    var $total_con_viaticos;
    var $total_reintegrable;
    var $total_aprobado;
    var $moneda;
    var $id_usuario;
    var $fecha_version;
    var $periodo;


    // metodos que devuelven valores
    function getSubTotalSinViaticos()
    { return floatval($this->sub_total_sin_viaticos);}

    function getTotalConViaticos()
    { return floatval($this->total_con_viaticos);}

    function getTotalReintegrable()
    { return floatval($this->total_reintegrable);}

    function getTotalAprobado()
    { return floatval($this->total_aprobado);}

    function getMoneda()
    { return $this->moneda;}

    function getIdUsuario()
    { return $this->id_usuario;}

    function getFechaVersion()
    { return $this->fecha_version;}

    function getPeriodo()
    { return $this->periodo;}


    // metodos que setean los valores
    function setSubTotalSinViaticos($val)
    { $this->sub_total_sin_viaticos=$val;}

    function setTotalConViaticos($val)
    {  $this->total_con_viaticos=$val;}

    function setTotalReintegrable($val)
    {  $this->total_reintegrable=$val;}

    function setTotalAprobado($val)
    {  $this->total_aprobado=$val;}

    function setMoneda($val)
    {  $this->moneda=$val;}

    function setIdUsuario($val)
    {  $this->id_usuario=$val;}

    function setFechaVersion($val)
    {  $this->fecha_version=$val;}

    function setPeriodo($val)
    {  $this->periodo=$val;}


    public function insertVersion($estado){

        /*$f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into plan_maestro_version(fecha_version, id_usuario, subtotal_s_viaticos, total_c_viaticos, total_reintegrable, total_aprobado, moneda)".
            "values(SYSDATE, $this->id_usuario, $this->sub_total_sin_viaticos , $this->total_con_viaticos, $this->total_reintegrable, $this->total_aprobado, '$this->moneda')";
        $obj_emp->executeQuery($query);
        return $obj_emp->getAffect();*/
        //$estado=0;
        $f=new Factory();
        $obj_ver=$f->returnsQuery();
        $query='BEGIN GENERARVERSION(:id_usuario, :subtotal_s_viaticos, :total_c_viaticos, :total_reintegrable, :total_aprobado, :moneda, :periodo, :estado); END;';
        $topa = $obj_ver->dpParse($query);

        $obj_ver->dpBind(':id_usuario', $this->getIdUsuario());
        $obj_ver->dpBind(':subtotal_s_viaticos', $this->getSubTotalSinViaticos());
        $obj_ver->dpBind(':total_c_viaticos', $this->getTotalConViaticos());
        $obj_ver->dpBind(':total_reintegrable', $this->getTotalReintegrable());
        $obj_ver->dpBind(':total_aprobado', $this->getTotalAprobado());
        $obj_ver->dpBind(':moneda', $this->getMoneda());
        $obj_ver->dpBind(':periodo', $this->getPeriodo());
        oci_bind_by_name($topa,':estado', $estado, 1);  //oci_bind_by_name($topa,':estado', $estado, -1, SQLT_INT);

        $obj_ver->dpExecute();
        return $estado;

    }


}


?>