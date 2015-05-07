
// Handeblars 

//esta funcion handlebar se le envian dos datos esto es para romper ciclos en cierto punto
Handlebars.registerHelper('divisorde', function(numero,multiplo,options) {
  var numerodos = numero+1;
  var mul = multiplo;
  var result = numerodos%mul;

  if(numero == 1)
  {
        return options.inverse(this);
  }else
  {

     if (result == 0)
    {
        return options.fn(this);
    }
    else {
        return options.inverse(this);
    }

  }

 


});


//le suma 1 al index
Handlebars.registerHelper('setIndex', function(value){
    //this.index = Number(value + 1); //I needed human readable index, not zero based
    return this.index = Number(value + 1);
});



//Handlebars




function  cargar_plantilla(nombreplantilla,resultados)
{
    var contenedor_res = jQuery('.no');
    var action = '';
    var parametros = '';
    var cargar_funcion_javascript = '0';
    var url = rutalibrary +'plantillas/'+nombreplantilla+'.php';
    var source = ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);
    var template = Handlebars.compile(source);
    var contexto = {items : resultados};
    var html    = template(contexto);
    return html;
}


function cargar_funcion_javascript(contenedor, respuesta, cargar_funcion_javascript)
{
    funcion = '' + cargar_funcion_javascript + '(contenedor,respuesta);';
    eval(funcion);
}



function ajax_general(contenedorrespuesta, parametros, cargar_funcion, url)
{
//console.log(contenedorrespuesta);
//console.log(parametros);
//console.log(cargar_funcion);
//console.log(url);

    jQuery.ajax({
        data: parametros,
        url: url,
        type: 'post',
        beforeSend: function() {
            if (cargar_funcion != '0')
            {
                contenedorrespuesta.html('<div class="cargando"></div>');
            }
        },
        success: function(response) {
            console.log(response);
            if (cargar_funcion != '0')
            {
                cargar_funcion_javascript(contenedorrespuesta, response, cargar_funcion);
            }
        },
        error: function(jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
        }
    });
}



function ajax_general_sin(contenedorrespuesta, parametros, cargar_funcion, url)
{

//console.log(contenedorrespuesta);
//console.log(parametros);
//console.log(cargar_funcion);
//console.log(url);

    var respuestaajax = jQuery.ajax({
        data: parametros,
        url: url,
        type: 'post',
        async: false,
        beforeSend: function() {
            if (cargar_funcion != '0')
            {
                contenedorrespuesta.html('<div class="cargando"></div>');
            }
        },
        success: function(response) {
            console.log(response);
            if (cargar_funcion != '0')
            {
                cargar_funcion_javascript(contenedorrespuesta, response, cargar_funcion);
            }
        },
        error: function(jqXHR, exception) {

            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
        }
    });

    console.log(respuestaajax.responseText);
    return(respuestaajax.responseText);


}


//Funciones de wordpress

//Esta funcion devuelve un arreglo de javascript con el id del menu que se intenta consultar
function get_menu_json_args_by_id(id_menu)
{
    var contenedor_res = jQuery('.no');
    var action = 'get_menu_json_args_by_id';
    var parametros = '&action='+action+'&id_menu='+id_menu;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);
}

//Esta funcion devulve un html con el menu que se le envie
function get_html_normal_menu(nombre,clase)
{
    var contenedor_res = jQuery('.no');
    var action = 'get_html_normal_menu';
    var parametros = '&action='+action+'&nombre='+nombre+'&clase='+clase+'';
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);
}




//por palabra,categoria,limite
function obtener_post_por_palabra_categoria_limite(palabra,categoria,limite)
{
    var contenedor_res = jQuery('.no');
    var action = 'obtener_post_por_palabra_categoria_limite';
    var parametros = '&action=' + action + '&palabra='+palabra+ '&categoria='+categoria+ '&limite='+limite;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);          
}


//obtener todas las categorias desendientes de una categoria por json
function obtener_todas_categorias_desendientes(id_categoria)
{
    var contenedor_res = jQuery('.no');
    var action = 'obtener_todas_categorias_desendientes';
    var parametros = '&action=' + action + '&id_categoria='  +id;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);          
}



//Funcion sirve para consultar post por id 
function  select_post_id(id)
{
    var contenedor_res = jQuery('.no');
    var action = 'select_post_id';
    var parametros = '&action=' + action + '&id='  +id;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);          
}


//Funcion sirve para consultar post por id o categoria
function  select_post_cat_slug(slugorid,limite)
{

    var contenedor_res = jQuery('.no');
    var action = 'select_post_cat_slug';
    var parametros = '&action=' + action + '&slugorid='  +slugorid+ '&limite='  +limite;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);
              
}


//Funcion retorna las imagenes adjuntas a un post
function  obtener_imagenes_post_por_post_id(postid)
{

    var contenedor_res = jQuery('.no');
    var action = 'obtener_imagenes_post_por_post_id';
    var parametros = '&action=' + action + '&postid='  +slugorid;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);
              
}

//wooocomerce
function  consultar_productos()
{

    var contenedor_res = jQuery('.no');
    var action = 'consultar_productos';
    var parametros = '&action=' + action;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);
              
}

function  consultar_productos_destacados()
{
    var contenedor_res = jQuery('.no');
    var action = 'consultar_productos_destacados';
    var parametros = '&action=' + action;
    var cargar_funcion_javascript = '0';
    var url = ajaxurl;
    return ajax_general_sin(contenedor_res, parametros, cargar_funcion_javascript, url);           
}
//wooocomerce

//Fin funciones de wordpress