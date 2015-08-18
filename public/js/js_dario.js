/**
 * Created by dario on 31/10/2014.
 */

//configura los datapicker de jquery ui en espanol
/*
$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);

*/




//oculta y desoculta el detalle de cada fila del reporte. El selector :not(.oculta) es para evitar que ocurra al clickear sobre tr que tienen la clase "oculta"
$(document).ready(function(){

    //$('#reportes > tbody > tr:not(.oculta)').on('click', function(){
    $(document).on('click', '#reportes > tbody > tr:not(.oculta)', function(){
        $(this).next('tr').toggle();
    } );



    $.periodos=function(){

        //establece los periodos para los select del ABM plan de capacitacion y solicitud de capacitacion
        var fecha = new Date();
        var anioActual=fecha.getFullYear();
        var mesActual=fecha.getMonth(); //devuelve los meses de 0 a 11
        //hasta el mes 9 inclusive (octubre) muestra solo año actual, despues año actual y siguiente
        var anioHasta= (mesActual<=9)? anioActual: anioActual+1;
        var periodos=[];
        for(var i=0; (i+anioActual)<=anioHasta; i++){
            periodos[i]=i+anioActual;
        }
        return periodos;
    };


    //Funcion para setear el alto de los dataTables dinamicamente... no la estoy usando.
    $.calcDataTableHeight = function() {
        return Math.round($(window).height() * 0.58);
    };


    //Para ajustar los textarea al tamaño del texto: http://stackoverflow.com/questions/3179385/val-doesnt-trigger-change-in-jquery
    $.each($('textarea'), function() {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function(el) {
            $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        $(this).on('keyup input change', function() { resizeTextarea(this); });
    });




});


