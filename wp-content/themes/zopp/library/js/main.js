jQuery('.logo__imagen').mouseenter(function(e){
    jQuery('.mano').css({
        'right': "36%",
        'top': "-115%"
    });
    setTimeout(function(){
        jQuery('.mano').css({
            'transform': "rotate(-5deg)"
        });
    },500);
    setTimeout(function(){
        jQuery('.mano').css({
            'transform': "rotate(5deg)"
        });
    },700);
    setTimeout(function(){
        jQuery('.mano').css({
            'transform': "rotate(-5deg)"
        });
    },900);
}).mouseleave(function(){
    jQuery('.mano').css({
        'right': '15%',
        'top': '0'
    });
    setTimeout(function(){
        jQuery('.mano').css({
            'transform': "rotate(0deg)"
        });
    },500);
});
jQuery(document).ready(function(){
   setTimeout(function(){
       jQuery('.loader').fadeOut(1000);
       jQuery('.mano').removeClass('mano_loading');
       hide_content();
       jQuery('#form_contact').unbind('submit').submit(function(){
            var nombre = jQuery('#nombre').val();
            var email = jQuery('#email').val();
            var mensaje = jQuery('#message').val();
            
            if(nombre == "" || email == "" || mensaje == ""){
                alert('No pueden haber campos vacios');
            }else{
                jQuery.ajax({
                    url: ajaxurl,
                    type: "GET",
                    data: {
                        action: "form",
                        name: nombre,
                        email: email,
                        mensaje: mensaje
                    },success: function(res){
                        alert(res);
                        jQuery('#nombre').val('');
                        jQuery('#email').val('');
                        jQuery('#message').val('');
                    }
                });
            }
        });
   },2000);
});


Array.prototype.shuffleArray = function() {
    for (var i = this.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = this[i];
        this[i] = this[j];
        this[j] = temp;
    }
    return this;
}