<?php if(!class_exists('raintpl')){exit;}?><link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-route.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular-animate.js"></script>

<script type="text/javascript">
  
 var app = angular.module('app', ['ngRoute', 'ngAnimate']);

    // configure our routes
    app.config(['$routeProvider', function($routeProvider) {
        
        $routeProvider

            // route for the home page
            .when('/', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/home.html',
                 controller  : 'mainController'
            })

            .when('/presentadores', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/presentadores.html',
                controller  : 'presentadoresController'
            })
            
            .when('/contacto', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/contacto.php',
                controller  : 'contactoController'
            })
            
            .when('/noticias', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/noticias.html',
                controller  : 'noticiaController'
            })
            
            .when('/noticias/:id', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/noticias.html',
                controller  : 'noticiaController'
            })
            
            .when('/categories/:id', {
                templateUrl : '/wp-content/themes/zopp/library/plantillas/angular/categories.html',
                controller  : 'categoriesController'
            })
            
            .otherwise({
                redirectTo: '/'
            });
    }]);

    // create the controller and inject Angular's $scope
    app.controller('categoriesController', ['$scope','$http','$rootScope','$routeParams', function($scope,$http,$rootScope,$routeParams) {
        // create a message to display in our view
        var animations = ['page-home','page-contact','page-about'];
    
        $scope.pageClass = animations[0];
        
        setTimeout(function(){
            animar_contenedor();
        },500);
        
        var id = $routeParams.id;
        
        if(id == 6){
            $scope.img = "/wp-content/uploads/material/video_b.png";
        }else if(id == 7){
            $scope.img = "/wp-content/uploads/material/soc_b.png";
        }else if(id == 8){
            $scope.img = "/wp-content/uploads/material/tec_b.png";
        }else{
            window.location = "/";
        }
        
        // ajax para las noticias segun el id
        $http({
            url: ajaxurl,
            method: "GET",
            params:{
                action:"noticias",
                id:id
            }
        }).success(function(res){
           $rootScope.datos = res;
           $scope.datos = $rootScope.datos;
        });
        
        jQuery(document).ready(function(){
            var top = 0;
            var height = 0;
            
            if(window.innerWidth > 1200){
                height = -897.5;
            }else if(window.innerWidth > 996 && window.innerWidth <= 1200){
                height = -730.5;
            }else if(window.innerWidth > 560 && window.innerWidth <= 996){
                height = -737;
            }else if(window.innerWidth > 480 && window.innerWidth <= 560){
                jQuery('.logo .separador.compartir').hide();
                jQuery('footer .separador.compartir').hide();
                height = -612.5;
            }else if(window.innerWidth <= 480){
                alert();
                jQuery('.logo .separador.compartir').hide();
                jQuery('footer .separador.compartir').hide();
                height = -612.5;
            }
            if(window.innerWidth <= 480){
                jQuery('.col-xs-3').eq(0).next().removeClass('col-xs-6').addClass('col-xs-12');
                jQuery('.col-xs-3').eq(2).next().removeClass('col-xs-6').addClass('col-xs-12');
                jQuery('.col-xs-3').remove();
            }
            
            jQuery(window).resize(function(){
                if(window.innerWidth > 1200){
                    height = -897.5;
                }else if(window.innerWidth > 996 && window.innerWidth <= 1200){
                    height = -730.5;
                }else if(window.innerWidth > 560 && window.innerWidth <= 996){
                    height = -737;
                }else if(window.innerWidth > 480 && window.innerWidth <= 560){
                    jQuery('.logo .separador.compartir').hide();
                    jQuery('footer .separador.compartir').hide();
                    height = -612.5;
                }else if(window.innerWidth <= 480){
                    alert();
                    jQuery('.logo .separador.compartir').hide();
                    jQuery('footer .separador.compartir').hide();
                    height = -612.5;
                }
                if(window.innerWidth <= 480){
                    jQuery('.col-xs-3').eq(0).next().removeClass('col-xs-6').addClass('col-xs-12');
                    jQuery('.col-xs-3').eq(2).next().removeClass('col-xs-6').addClass('col-xs-12');
                    jQuery('.col-xs-3').remove();
                }
            });
            var gif = ['110.GIF','285.GIF','300.GIF','301.GIF','480.GIF','728.GIF'];
            var x = 0;
            jQuery('.noticias > div').unbind('click').click(function(e){
            debugger;
                
                x = Math.floor((Math.random() * 6) + 1);
                var paginador = e.target.className;
                var tope = jQuery('.articulos').innerHeight();
                if(paginador == "left"){
                    if(top == 0){
                        return;
                    }else{
                        jQuery('.loader_notices').css('background-image','url(/wp-content/uploads/material/'+gif[x-1]+')').show();
                        top += height*-1;
                        jQuery('.noticias').find('.articulos').addClass('blur').css('top',top+'px');
                    }
                }else{
                    if(( tope - 5 ) <= ( height * 1 ) + 5 ){
                        return; 
                    }
                    else if(jQuery('.articulos').css('top') == "0px"){
                        jQuery('.loader_notices').css('background-image','url(/wp-content/uploads/material/'+gif[x-1]+')').show();
                        top = height;
                        jQuery('.noticias').find('.articulos').addClass('blur').css('top',top+'px');
                    }else{
                        if((top*-1) >= (tope-(height*-1))){
                            return;
                        }else{
                            jQuery('.loader_notices').css('background-image','url(/wp-content/uploads/material/'+gif[x-1]+')').show();
                            top += height;
                            jQuery('.noticias').find('.articulos').addClass('blur').css('top',top+'px');
                        }
                    }
                    
                }
                setTimeout(function(){
                    jQuery('.loader_notices').fadeOut(500);
                    jQuery('.noticias .articulos').removeClass('blur');
                },1000);
            });
        });
        
        // Ajax para el logo
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"logo_page"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.logo = data;
            jQuery('.logo__imagen').attr('src',data.img);
            
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // Ajax para el presentadores
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"presentadores",
                ref:"home"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.presentadores = data;
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        $scope.noticia=function(id){
            // animar_contenedor();
            window.location = "/#/noticias/"+id;
        }
        
        $scope.titulo_pagina = 'Categories -- Play App';
        jQuery("title").html($scope.titulo_pagina);
    }]);
    
    app.controller('presentadoresController', ['$scope','$http','datos_noticias', function($scope,$http,datos_noticias) {
        // create a message to display in our view
        var animations = ['page-home','page-contact','page-about'];
    
        $scope.pageClass = animations[0];
        
        setTimeout(function(){
            animar_contenedor();
        },500);
        
        // Ajax para el logo
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"logo_page"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.logo = data;
            jQuery('.logo__imagen').attr('src',data.img);
            
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // Ajax para el presentadores
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"presentadores"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.presentadores_page = data;
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        $scope.message = 'Everyone come and see how good I look!';
        $scope.titulo_pagina = 'Presentadores -- Play App';
        jQuery("title").html($scope.titulo_pagina);
    }]);
    
    // create the controller and inject Angular's $scope
    app.controller('noticiaController',[ '$scope','$http','$routeParams', function($scope,$http,$routeParams) {
        // create a message to display in our view
        $scope.id = $routeParams.id;
        var animations = ['page-home','page-contact','page-about'];
    
        $scope.pageClass = animations[0];
        setTimeout(function(){
            animar_contenedor();
        },500);
        // Ajax para el logo
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"logo_page"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.logo = data;
            jQuery('.logo__imagen').attr('src',data.img);
            
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // ajax que trae todos los datos de la entrada
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"entrada",
                id:$scope.id
            }
        }).success(function(data, status, headers, config) {
            console.log('esteeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
            console.log(data);
            try{
                
                $scope.titulo_entrada = data.metadata.post_title;
                $scope.resumen = data.metadata.post_content;
                 $scope.contenido = data.metadata.post_content;
                 $scope.img = data.imagen;
                
                //  $scope.datos = data;
                //  $scope.autor = data[0].custom_fields.autor[0];
                // $scope.twitter = data[0].custom_fields.twitter[0];
                // $scope.twitter_url = data[0].custom_fields.twitter[0].split('@')[1];
                if(data.url == false || data.url == null){
                    $scope.img_autor = "http://s3.amazonaws.com/37assets/svn/765-default-avatar.png";
                }else{
                    $scope.img_autor =  data.url;//"http://s3.amazonaws.com/37assets/svn/765-default-avatar.png";  
                }
                // console.warn(data);
               // alert($scope.img_autor);
            }catch(e){
                // $scope.titulo_entrada = data[0].post_title;
                // $scope.resumen = data[0].resumen;
                // $scope.contenido = data[0].contenidocomleto;
                // $scope.img = data[0].urlimg[0];
                
                // $scope.datos = data;
                // $scope.autor = data[0].custom_fields.autor[0];
                // $scope.twitter = data[0].custom_fields.twitter[0];
                // $scope.twitter_url = data[0].custom_fields.img[0];er[0].split('@')[1];
                 $scope.img_autor = "http://s3.amazonaws.com/37assets/svn/765-default-avatar.png";  
                // alert(data[0].g);
                // alert($scope.img_autor);
            }
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // ajax que trae todos los datos de la entrada 2
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"entrada_",
                id:$scope.id
            }
        }).success(function(data, status, headers, config) {
            console.log('esteeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee------------------------');
            console.log(data);
            // try{
                
            //     $scope.titulo_entrada = data.metadata.post_title;
            //     $scope.resumen = data.metadata.post_content;
            //      $scope.contenido = data.metadata.post_content;
            //      $scope.img = data.imagen;
                
            //     //  $scope.datos = data;
                 $scope.autor = data[0].custom_fields.autor[0];
                $scope.twitter = data[0].custom_fields.twitter[0];
                $scope.twitter_url = data[0].custom_fields.twitter[0].split('@')[1];
            //     if(data.url == false || data.url == null){
            //         $scope.img_autor = "http://s3.amazonaws.com/37assets/svn/765-default-avatar.png";
            //     }else{
            //         $scope.img_autor =  data.url;//"http://s3.amazonaws.com/37assets/svn/765-default-avatar.png";  
            //     }
            //     // console.warn(data);
            //   // alert($scope.img_autor);
            // }catch(e){
            //     // $scope.titulo_entrada = data[0].post_title;
            //     // $scope.resumen = data[0].resumen;
            //     // $scope.contenido = data[0].contenidocomleto;
            //     // $scope.img = data[0].urlimg[0];
                
            //     // $scope.datos = data;
            //     // $scope.autor = data[0].custom_fields.autor[0];
            //     // $scope.twitter = data[0].custom_fields.twitter[0];
            //     // $scope.twitter_url = data[0].custom_fields.img[0];er[0].split('@')[1];
            //      $scope.img_autor = "http://s3.amazonaws.com/37assets/svn/765-default-avatar.png";  
            //     // alert(data[0].g);
            //     // alert($scope.img_autor);
            // }
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
         // Ajax para las noticias del footer
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"noticias",
                ref:'1'
            }
        }).success(function(data, status, headers, config) {
            
            var $n = data.entradas.shuffleArray();
            var $tmp = [];
            
            $n.forEach(function(ix,ox){
                if(ox<3){
                    $tmp.push(ix);
                }
            });
            
            $scope.not_ = $tmp;
            
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // Click de cada noticia
        $scope.noticia=function(id){
            // animar_contenedor();
            window.location = "/#/noticias/"+id;
        }
        
        $scope.titulo_pagina = 'Noticias -- Play App';
        jQuery("title").html($scope.titulo_pagina);
        jQuery('.navegador__contenedor').css('background-color','#555658');
        // console.clear();
    }]);

    // create the controller and inject Angular's $scope
    app.controller('contactoController', ['$scope','$http','datos_noticias', function($scope,$http,datos_noticias) {
        // create a message to display in our view
        var animations = ['page-home','page-contact','page-about'];
    
        $scope.pageClass = animations[0];
        setTimeout(function(){
            animar_contenedor();
        },500);
        
        // Ajax para el logo
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"logo_page"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.logo = data;
            jQuery('.logo__imagen').attr('src',data.img);
            
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // // Ajax para el formulario
        // $http({
        //     url: ajaxurl,
        //     method: "GET",
        //     params: {
        //         action:"form"
        //     }
        // }).success(function(data, status, headers, config) {
            
        //     $scope.form = data;
        //     //jQuery('.logo__imagen').attr('src',data.img);
            
        // }).error(function(data, status, headers, config) {
        //     alert("no ejecuto el ajax formulario");
        // });
        
       $scope.titulo_pagina = 'Contacto -- Play App';
        jQuery("title").html($scope.titulo_pagina);
    }]);
    
    // create the controller and inject Angular's $scope
    app.controller('mainController', ['$scope','$http','datos_noticias','$rootScope', function($scope,$http,datos_noticias,$rootScope) {
        
        var animations = ['page-home','page-contact','page-about'];
    
        $scope.pageClass = animations[0];
        setTimeout(function(){
            animar_contenedor();
        },500);
        
        var top = 0;
        var height = 0;
        
        if(window.innerWidth > 1200){
            height = -897.5;
        }else if(window.innerWidth > 996 && window.innerWidth <= 1200){
            height = -730.5;
        }else if(window.innerWidth > 560 && window.innerWidth <= 996){
            height = -737;
        }else if(window.innerWidth > 480 && window.innerWidth <= 560){
            jQuery('.logo .separador.compartir').hide();
            ery('footer .separador.compartir').hide();
            height = -612.5;
        }else if(window.innerWidth <= 480){
            // alert();
            jQuery('.logo .separador.compartir').hide();
            jQuery('footer .separador.compartir').hide();
            height = -612.5;
        }
        if(window.innerWidth <= 480){
            jQuery('.col-xs-3').eq(0).next().removeClass('col-xs-6').addClass('col-xs-12');
            jQuery('.col-xs-3').eq(2).next().removeClass('col-xs-6').addClass('col-xs-12');
            jQuery('.col-xs-3').remove();
        }
        
        jQuery(window).resize(function(){
            if(window.innerWidth > 1200){
                height = -897.5;
            }else if(window.innerWidth > 996 && window.innerWidth <= 1200){
                height = -730.5;
            }else if(window.innerWidth > 560 && window.innerWidth <= 996){
                height = -737;
            }else if(window.innerWidth > 480 && window.innerWidth <= 560){
                jQuery('.logo .separador.compartir').hide();
                ery('footer .separador.compartir').hide();
                height = -612.5;
            }else if(window.innerWidth <= 480){
                // alert();
                jQuery('.logo .separador.compartir').hide();
                jQuery('footer .separador.compartir').hide();
                height = -612.5;
            }
            if(window.innerWidth <= 480){
                jQuery('.col-xs-3').eq(0).next().removeClass('col-xs-6').addClass('col-xs-12');
                jQuery('.col-xs-3').eq(2).next().removeClass('col-xs-6').addClass('col-xs-12');
                jQuery('.col-xs-3').remove();
            }
        });
        var gif = ['110.GIF','285.GIF','300.GIF','301.GIF','480.GIF','728.GIF'];
        var x = 0;
        jQuery('.noticias > div').unbind('click').click(function(e){
            //debugger;
            x = Math.floor((Math.random() * 6) + 1);
            var paginador = e.target.className;
            var tope = jQuery('.articulos').innerHeight();
            if(paginador == "left"){
                if(top == 0){
                    return;
                }else{
                    jQuery('.loader_notices').css('background-image','url(/wp-content/uploads/material/'+gif[x-1]+')').show();
                    top += height*-1;
                    jQuery('.noticias').find('.articulos').addClass('blur').css('top',top+'px');
                }
            }else{
                if(jQuery('.articulos').css('top') == "0px"){
                    jQuery('.loader_notices').css('background-image','url(/wp-content/uploads/material/'+gif[x-1]+')').show();
                    top = height;
                    jQuery('.noticias').find('.articulos').addClass('blur').css('top',top+'px');
                }else{
                    if((top*-1) >= (tope-(height*-1))){
                        return;
                    }else{
                        jQuery('.loader_notices').css('background-image','url(/wp-content/uploads/material/'+gif[x-1]+')').show();
                        top += height;
                        jQuery('.noticias').find('.articulos').addClass('blur').css('top',top+'px');
                    }
                }
                
            }
            setTimeout(function(){
                jQuery('.loader_notices').fadeOut(500);
                jQuery('.noticias .articulos').removeClass('blur');
            },1000);
        });
        
        jQuery('.more_notices').unbind('click').click(function(){
           var url = "."+jQuery(this).attr('data-url');
           jQuery('body').animate({scrollTop: jQuery(url).offset().top - 5},2000);
       });
        
        // Ajax para el logo
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"logo_page"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.logo = data;
            jQuery('.logo__imagen').attr('src',data.img);
            
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // ajax para el menu slider
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"menu_slider"
            }
        }).success(function(data, status, headers, config) {
            $scope.menu_slider = data;
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // Ajax para el slider
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"slider"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.slider = data;
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // Ajax para el menu
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"menu"
            }
        }).success(function(data, status, headers, config) {
            $scope.menu = data;
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // Ajax para el presentadores
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"presentadores",
                ref:"home"
            }
        }).success(function(data, status, headers, config) {
            $scope.presentadores = data;
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });
        
        // Ajax para el banner
        $http({
            url: ajaxurl,
            method: "GET",
            params: {
                action:"banner"
            }
        }).success(function(data, status, headers, config) {
            
            $scope.banner = data;
        }).error(function(data, status, headers, config) {
            alert("no ejecuto el ajax");
        });

        // Titulo de la Página
        $scope.titulo_pagina = 'Home -- Play App';
        
        
        // Click de los titulos del menu
        $scope.listCategorias=function(id){
           /* $http({
                url: ajaxurl,
                method: "GET",
                params:{
                    action:"noticias",
                    id:id
                }
            }).success(function(res){
                   $rootScope.datos = res;
                   $scope.datos = $rootScope.datos;
            });
            
            var m = datos_noticias.getCategories(id);
            $scope.datos = m;*/
            window.location = "/#/categories/"+id;
        }
        
        // Click de cada noticia
        $scope.noticia=function(id){
            // animar_contenedor();
            window.location = "/#/noticias/"+id;
        }
        jQuery("title").html($scope.titulo_pagina);
        jQuery('.navegador__contenedor').css('background-color','#555658');
        
        
    }]);
    
    // Directiva
    app.factory('datos_noticias',['$rootScope','$http',function ($rootScope,$http) {        
        $rootScope.datos = 'all';
        // animar_contenedor();
        
        
        $http({
            url: ajaxurl,
            method: "GET",
            params:{
                action:"noticias"
            }
        }).success(function(res){
               $rootScope.datos = res.entradas;
        });
        
        return {
            getCategories:function($id){
                $rootScope.datos = $id;
                return $rootScope.datos;
            }
        }
    }]);
    
    // filtro
    app.filter('filterHtml', ['$sce', function($sce){
      return function(val) {
        return $sce.trustAsHtml(val);
      };
    }]);
    
    function animar_contenedor(){
        jQuery('body').animate({scrollTop:0}, '100');
        jQuery('#content').addClass('blur_animated');
        setTimeout(function(){
            jQuery('#content').removeClass('blur_animated');
        },500);
    }
    
    function hide_content(){
        jQuery('#content').css('display','none!important');;
    }

</script>

<div ng-app="app">

    <div class="page {{ pageClass }}"  ng-view>
        
    </div>

</div>