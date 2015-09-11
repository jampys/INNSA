<?php


class Evaluacion
{
    var $id_evaluacion;
    var $id_asignacion;
    var $fecha_evaluacion;
    var $conceptos_importantes;
    var $aspectos_faltaron;
    var $mejorar_desempenio;

    var $obj_1;
    var $obj_2;
    var $obj_3;

    var $ev_i_dominio;
    var $ev_i_lenguaje;
    var $ev_i_claridad;
    var $ev_i_material;
    var $ev_i_consultas;
    var $ev_i_didactico;
    var $ev_i_participacion;

    var $ev_l_duracion;
    var $ev_l_comunicacion;
    var $ev_l_material;
    var $ev_l_break;
    var $ev_l_hotel;

    var $comentarios;


    // metodos que devuelven valores
    function getIdEvaluacion()
    { return $this->id_evaluacion;}

    function getIdAsignacion()
    { return $this->id_asignacion;}

    function getFechaEvaluacion()
    { return $this->fecha_evaluacion;}

    function getConceptosImportantes()
    { return $this->conceptos_importantes;}

    function getAspectosFaltaron()
    { return $this->aspectos_faltaron;}

    function getMejorarDesempenio()
    { return $this->mejorar_desempenio;}

    function getObj1()
    { return $this->obj_1;}

    function getObj2()
    { return $this->obj_2;}

    function getObj3()
    { return $this->obj_3;}

    function getEvIDominio()
    { return $this->ev_i_dominio;}

    function getEvILenguaje()
    { return $this->ev_i_lenguaje;}

    function getEvIClaridad()
    { return $this->ev_i_claridad;}

    function getEvIMaterial()
    { return $this->ev_i_material;}

    function getEvIConsultas()
    { return $this->ev_i_consultas;}

    function getEvIDidactico()
    { return $this->ev_i_didactico;}

    function getEvIParticipacion()
    { return $this->ev_i_participacion;}

    function getEvLDuracion()
    { return $this->ev_l_duracion;}

    function getEvLComunicacion()
    { return $this->ev_l_comunicacion;}

    function getEvLMaterial()
    { return $this->ev_l_material;}

    function getEvLBreak()
    { return $this->ev_l_break;}

    function getEvLHotel()
    { return $this->ev_l_hotel;}

    function getComentarios()
    { return $this->comentarios;}


    // metodos que setean los valores
    function setIdEvaluacion($val)
    { $this->id_evaluacion=$val;}

    function setIdAsignacion($val)
    {  $this->id_asignacion=$val;}

    function setFechaEvaluacion($val)
    {  $this->fecha_evaluacion=$val;}

    function setConceptosImportantes($val)
    {  $this->conceptos_importantes=$val;}

    function setAspectosFaltaron($val)
    {  $this->aspectos_faltaron=$val;}

    function setMejorarDesempenio($val)
    {  $this->mejorar_desempenio=$val;}

    function setObj1($val)
    {  $this->obj_1=$val;}

    function setObj2($val)
    {  $this->obj_2=$val;}

    function setObj3($val)
    {  $this->obj_3=$val;}

    function setEvIDominio($val)
    {  $this->ev_i_dominio=$val;}

    function setEvILenguaje($val)
    {  $this->ev_i_lenguaje=$val;}

    function setEvIClaridad($val)
    {  $this->ev_i_claridad=$val;}

    function setEvIMaterial($val)
    {  $this->ev_i_material=$val;}

    function setEvIConsultas($val)
    {  $this->ev_i_consultas=$val;}

    function setEvIDidactico($val)
    {  $this->ev_i_didactico=$val;}

    function setEvIParticipacion($val)
    {  $this->ev_i_participacion=$val;}



    function setEvLDuracion($val)
    {  $this->ev_l_duracion=$val;}

    function setEvLComunicacion($val)
    {  $this->ev_l_comunicacion=$val;}

    function setEvLMaterial($val)
    {  $this->ev_l_material=$val;}

    function setEvLBreak($val)
    {  $this->ev_l_break=$val;}

    function setEvLHotel($val)
    {  $this->ev_l_hotel=$val;}


    function setComentarios($val)
    {  $this->comentarios=$val;}



    public function getEvaluacionByAsignacion($id){
        $f=new Factory();
        $obj_ev=$f->returnsQuery();
        $obj_ev->executeQuery("select * from cap_evaluacion ev where ev.id_asignacion = $id");
        return $obj_ev->fetchAll();
    }

    public function getObjetivosEvaluacionByAsignacion($id){
        $f=new Factory();
        $obj_ev=$f->returnsQuery();
        $query="select co.objetivo_1, co.objetivo_2, co.objetivo_3 from cap_comunicacion co, asignacion_plan ap where co.id_asignacion = ap.id_asignacion and co.id_asignacion = $id";
        $obj_ev->executeQuery($query);
        return $obj_ev->fetchAll();
    }

    public function updateEvaluacion(){
        /*
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cap_evaluacion set conceptos_importantes='$this->conceptos_importantes', aspectos_faltaron='$this->aspectos_faltaron', mejorar_desempenio='$this->mejorar_desempenio',".
            " ev_i_dominio=$this->ev_i_dominio, ev_i_lenguaje=$this->ev_i_lenguaje, ev_i_claridad=$this->ev_i_claridad, ev_i_material=$this->ev_i_material, ev_i_consultas=$this->ev_i_consultas, ev_i_didactico=$this->ev_i_didactico, ev_i_participacion=$this->ev_i_participacion,".
            " ev_l_duracion=$this->ev_l_duracion, ev_l_comunicacion=$this->ev_l_comunicacion, ev_l_material=$this->ev_l_material, ev_l_break=$this->ev_l_break, ev_l_hotel=$this->ev_l_hotel,".
            " obj_1=$this->obj_1, obj_2=$this->obj_2, obj_3=$this->obj_3, comentarios='$this->comentarios'".
            " where id_evaluacion = $this->id_evaluacion";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect(); */

        $f=new Factory();
        $obj_eva=$f->returnsQuery();
        $query="update cap_evaluacion set conceptos_importantes = :conceptos_importantes, aspectos_faltaron = :aspectos_faltaron, mejorar_desempenio = :mejorar_desempenio,".
            " ev_i_dominio=$this->ev_i_dominio, ev_i_lenguaje=$this->ev_i_lenguaje, ev_i_claridad=$this->ev_i_claridad, ev_i_material=$this->ev_i_material, ev_i_consultas=$this->ev_i_consultas, ev_i_didactico=$this->ev_i_didactico, ev_i_participacion=$this->ev_i_participacion,".
            " ev_l_duracion=$this->ev_l_duracion, ev_l_comunicacion=$this->ev_l_comunicacion, ev_l_material=$this->ev_l_material, ev_l_break=$this->ev_l_break, ev_l_hotel=$this->ev_l_hotel,".
            " obj_1=$this->obj_1, obj_2=$this->obj_2, obj_3=$this->obj_3, comentarios = :comentarios".
            " where id_evaluacion = $this->id_evaluacion";
        $obj_eva->dpParse($query);

        $obj_eva->dpBind(':conceptos_importantes', $this->conceptos_importantes);
        $obj_eva->dpBind(':aspectos_faltaron', $this->aspectos_faltaron);
        $obj_eva->dpBind(':mejorar_desempenio', $this->mejorar_desempenio);
        $obj_eva->dpBind(':comentarios', $this->comentarios);

        $obj_eva->dpExecute();
        return $obj_eva->getAffect();

    }


    public function insertEvaluacion(){
        /*
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into cap_evaluacion(id_asignacion, conceptos_importantes, aspectos_faltaron, mejorar_desempenio, fecha_evaluacion,".
            " ev_i_dominio, ev_i_lenguaje, ev_i_claridad, ev_i_material, ev_i_consultas, ev_i_didactico, ev_i_participacion, ev_l_duracion, ev_l_comunicacion, ev_l_material, ev_l_break, ev_l_hotel, obj_1, obj_2, obj_3, comentarios)".
            " values($this->id_asignacion, '$this->conceptos_importantes', '$this->aspectos_faltaron', '$this->mejorar_desempenio', SYSDATE,".
            " $this->ev_i_dominio, $this->ev_i_lenguaje, $this->ev_i_claridad, $this->ev_i_material, $this->ev_i_consultas, $this->ev_i_didactico, $this->ev_i_participacion, $this->ev_l_duracion, $this->ev_l_comunicacion, $this->ev_l_material, $this->ev_l_break, $this->ev_l_hotel, $this->obj_1, $this->obj_2, $this->obj_3, '$this->comentarios')";
        $obj_emp->executeQuery($query);
        return $obj_emp->getAffect(); */

        $f=new Factory();
        $obj_eva=$f->returnsQuery();
        $query="insert into cap_evaluacion(id_asignacion, conceptos_importantes, aspectos_faltaron, mejorar_desempenio, fecha_evaluacion,".
            " ev_i_dominio, ev_i_lenguaje, ev_i_claridad, ev_i_material, ev_i_consultas, ev_i_didactico, ev_i_participacion, ev_l_duracion, ev_l_comunicacion, ev_l_material, ev_l_break, ev_l_hotel, obj_1, obj_2, obj_3, comentarios)".
            " values($this->id_asignacion, :conceptos_importantes, :aspectos_faltaron, :mejorar_desempenio, SYSDATE,".
            " $this->ev_i_dominio, $this->ev_i_lenguaje, $this->ev_i_claridad, $this->ev_i_material, $this->ev_i_consultas, $this->ev_i_didactico, $this->ev_i_participacion, $this->ev_l_duracion, $this->ev_l_comunicacion, $this->ev_l_material, $this->ev_l_break, $this->ev_l_hotel, $this->obj_1, $this->obj_2, $this->obj_3, :comentarios)";
        $obj_eva->dpParse($query);

        $obj_eva->dpBind(':conceptos_importantes', $this->conceptos_importantes);
        $obj_eva->dpBind(':aspectos_faltaron', $this->aspectos_faltaron);
        $obj_eva->dpBind(':mejorar_desempenio', $this->mejorar_desempenio);
        $obj_eva->dpBind(':comentarios', $this->comentarios);

        $obj_eva->dpExecute();
        return $obj_eva->getAffect();
        echo $query;

    }









}


?>