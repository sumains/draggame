<?php session_start(); ?>
<script type="text/javascript">
    $(document).ready(function(){
    lienzo = document.getElementById("lienzo");
    contexto = lienzo.getContext("2d");
    personajes[0] = new Personaje();
    personajes[1] = new Personaje();
    personajes[0].setImage(cochemiguel[1]);
    personajes[1].setImage(cochepedro[1]);
    
    yo = new Personaje();
})

$(document).keydown(function(e){
    
    
    //ACELERAR PERSONAJE
    if(e.which == 39){ 
        yo.setMovimientoPersonaje('acelerar');        
        
        yo.mover();
        //ACTUALIZAMOS BASE DE DATOS CON LA POSICION DEL COCHE
        $.ajax({
            method: "POST",
            url: "php/actualizarposicion.php",
            data: { posx: yo.getPosX()}
        })
        .done(function(msg) {
            console.log(msg);
        });
        
    }
    
})
var contador = 0;
function loop(){

    //LIMPIAMOS EL CANVAS
    contexto.clearRect(0,0,800,600);
    if(contador % 30 == 0){
    //OBTENEMOS LOS JUGADORES 
        $.getJSON( "php/obtenerjugadores.php", function( json ) {
            //console.log( "JSON Data: " + json.length );
            for(var j = 0; j<json.length;j++){
                    
                    personajes[j].setPosX(json[j].posicion);
                    
                    console.log(json[j].posicion);
                }
        });
        /*$.ajax({ 
                method: "POST",
                url: "php/obtenerjugadores.php",
                data: {}
            })
            .done(function(msg) {
                var jugadores = JSON.parse(msg);
                for(var j = 0; j<jugadores.length;j++){
                    
                    personajes[j].setPosX(jugadores[j].posicion);
                    
                }
                
            });*/
        
    }
    for(var j = 0; j<personajes.length;j++){

        personajes[j].pintar();

    }
    contador ++;
    //personaje.pintar();
    
    
    
    //LIMPIAMOS Y CREAMOS EL BUCLE
    clearTimeout(temporizador);
    temporizador = setTimeout("loop()",30);

}
</script>