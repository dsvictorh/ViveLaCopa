function submit(object){
    
    object.form.submit();
}


function cargar_check_estado(radio_value){  
           
       if (radio_value == 'activo'){
           
           document.getElementById('chk_activos').checked = true;  
           
           
       }else{
           
           document.getElementById('chk_cancelados').checked = true;
           
       }
            
        
}

function cargar_check_fases(radio_value){  
           
       if (radio_value == '1'){
           
           document.getElementById('chk_uno').checked = true;  
           
           
       }else{
           
           document.getElementById('chk_dos').checked = true;
           
       }
               
}

function cargar_check_equipos(radio_value){  
           
       if (radio_value == 'aprobado'){
           
           document.getElementById('chk_aprobados').checked = true;  
           
           
       }else if(radio_value == 'pendiente'){
           
           document.getElementById('chk_pendientes').checked = true;
           
       }else{
           
           document.getElementById('chk_no_aprobados').checked = true;
           
       }
              
}

function cargar_equipos(radio_value){
    
    cargar_check_equipos(radio_value);
}




function cargar_torneos(radio_value, fases){
    
    cargar_check_estado(radio_value);
    
    if(document.getElementsByName('chk_fases').length != 0){
        
        cargar_check_fases(fases);
        
    }
    
}

function cargar_administradores(radio_value, torneo, torneos){
    
    cargar_check_estado(radio_value);
    
    for(var i = 0; i < document.getElementById('cmb_torneo').length; i++){
           
           
           if (document.getElementById('cmb_torneo').options[i].value == torneo){
               
               document.getElementById('cmb_torneo').options[i].selected = true;
               
           }
           
       }
       
       if(document.getElementById('cmb_torneos') != null){
       
        for(var j = 0; j < document.getElementById('cmb_torneos').length; j++){


            if (document.getElementById('cmb_torneos').options[j].value == torneos){

                document.getElementById('cmb_torneos').options[j].selected = true;

            }

        }
       
       }
    
}

function cargar_partidos(hora, minutos, ampm){
    
     if(document.getElementById('cmb_hora')){
        
        for(var i = 0; i < document.getElementById('cmb_hora').length; i++){
           
           
           if (document.getElementById('cmb_hora').options[i].value == hora){
               
               document.getElementById('cmb_hora').options[i].selected = true;
               
           }
           
       }
        
    }
    
    if(document.getElementById('cmb_minutos') != null){
        
        for(var j = 0; j < document.getElementById('cmb_minutos').length; j++){
           
           
           if (document.getElementById('cmb_minutos').options[j].value == minutos){
               
               document.getElementById('cmb_minutos').options[j].selected = true;
               
           }
           
       }
        
    }
    
    if(document.getElementById('cmb_am_pm') != null){
        
        for(var k = 0; k < document.getElementById('cmb_am_pm').length; k++){
           
           
           if (document.getElementById('cmb_am_pm').options[k].value == ampm){
               
               document.getElementById('cmb_am_pm').options[k].selected = true;
               
           }
           
       }
        
    }
    
}

function confirmar_guardar_partido_nuevo(){
    
    if(document.getElementsByName('guardar')[0].value == 'false'){
        
        if(document.getElementsByName('txt_goles_equipo_uno')[0].value == '0' && document.getElementsByName('txt_goles_equipo_dos')[0].value == '0'){
            
            if(confirm('Este partido ha terminado con un resultado 0 a 0?')){
                
                document.getElementsByName('guardar')[0].value = 'true';
                
            }
            
        }else{
        
            document.getElementsByName('guardar')[0].value = 'true';
        
        }
        
    }
    
    return true;
    
}

function confirmar(mensaje){
    
    return confirm(mensaje);
}

