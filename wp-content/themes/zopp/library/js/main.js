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