
//var cedulas = '';
var correos = '';
var registro = 1;

function guardar_correos(cadena){
    
    correos = cadena;
    
}

//function guardar_cedulas(cadena){
//    
//    cedulas = cadena;
//    
//}

function torneo_click(id_torneo){
    
    window.location = 'torneo.php?id_torneo=' + id_torneo;
    
} 

function mostrar_descripcion_partido(descripcion_partido, numero_cancha, fecha, e, es_llave){
    
    if(descripcion_partido != '' || numero_cancha != '0' || fecha != ''){
        
        if((descripcion = document.getElementById('descripcion_partido')) == null){
           

            background = document.createElement('div');
            background.id = 'descripcion_partido';
            background.onclick = function(){cerrar_descripcion_partido();};
            background.style.top = (((window.event)?event.clientY:e.clientY) + window.pageYOffset - 150) + 'px';
            background.style.left = ((es_llave)?((((window.event)?event.clientX:e.clientX) + 20 ) + 'px'):'70%');

            cancha = document.createElement('p');
            cancha.id = 'cancha';
            cancha.textContent = 'Cancha: ' + ((numero_cancha != '0')?numero_cancha:'N/A - ' + fecha);
            cancha.onclick = function(e){
                if(window.event){
                    
                    event.cancelBubble = true; 
                    
                }else{
                    
                    e.stopPropagation();

                }
   
            };
            
            x = document.createElement('p');
            x.id = 'cerrar';
            x.textContent = 'X';
            
            span = document.createElement('span');
            span.className = 'clear';


  
            background.appendChild(x);
            background.appendChild(cancha);
            background.appendChild(span);
            
            div = document.createElement('div');
            div.onclick = function(e){
                if(window.event){
                    
                    event.cancelBubble = true; 
                    
                }else{
                    
                    e.stopPropagation();

                }
   
            };
            
            descripcion = document.createElement('p');
            descripcion.id = 'detalle';
            descripcion.textContent = descripcion_partido;
            descripcion.onclick = function(e){
                if(window.event){
                    
                    event.cancelBubble = true; 
                    
                }else{
                    
                    e.stopPropagation();

                }
   
            };
            
            div.appendChild(descripcion);

            background.appendChild(div);
            

            contenido = document.getElementById('contenido');
            contenido.appendChild(background);       
        
        } 
      

    }
    
}

function block_descripcion_partido(descripcion_partido, numero_cancha, fecha, e, es_llave){

    if(descripcion_partido != '' || numero_cancha != '0' || fecha != ''){
        
        if((descripcion = document.getElementById('descripcion_partido')) != null){

            background = document.getElementById('descripcion_partido');
            background.style.top = (((window.event)?event.clientY:e.clientY) + window.pageYOffset - 150) + 'px';
            background.style.left = ((es_llave)?((((window.event)?event.clientX:e.clientX) + 20 ) + 'px'):'70%');
            background.className = 'block';
            
            cancha = window.top.document.getElementById('cancha');
            cancha.textContent = 'Cancha: ' + ((numero_cancha != '0')?numero_cancha:'N/A - ' + fecha);
            
            x = document.getElementById('cerrar');
            x.style.display = 'block';
            
            descripcion = document.getElementById('detalle');
            
            descripcion.textContent = descripcion_partido;
            
  
        }
           
    }else{
        
        cerrar_descripcion_partido();
        
    }
    
}

function esconder_descripcion_partido(){
    
    if((descripcion = document.getElementById('descripcion_partido')) != null){
   
        if(!descripcion.hasAttribute("class")){
   
            contenido = document.getElementById('contenido');
            contenido.removeChild(descripcion);
        
        }
    
    }
    
}

function cerrar_descripcion_partido(){
    
    
        if((descripcion = document.getElementById('descripcion_partido')) != null){

            if(descripcion.hasAttribute('class')){

                contenido = document.getElementById('contenido');
                contenido.removeChild(descripcion);

            }

        }    
}


function cancelar_registro(){
    
    document.getElementsByName('txt_nombre')[0].value = '';
    document.getElementsByName('txt_apellidos')[0].value = '';
    document.getElementsByName('txt_telefono')[0].value = '';
    document.getElementsByName('txt_correo')[0].value = '';
    
 
}

function guardar_registro(){
    
    special_chars = /[\\\+\*\?\^\$\[\(\)\|\}\°\¬\!\"\#\%\/\=\'\¿\¡\¨\´\;\:\~\&\>\<]/;
    correo = /^[a-z0-9]+((-|_|\.)[a-z0-9]+)*(-|_|\.)*@[a-z0-9]+((-|_|\.)[a-z0-9]+)*(\.[a-z]{1,3})$/;
    numero = /^([0-9]+(\-{0,1}))+$/;
    
    if(document.getElementsByName('txt_nombre')[0].value == '' 
    || document.getElementsByName('txt_apellidos')[0].value == ''
    || document.getElementsByName('txt_telefono')[0].value == ''
    || document.getElementsByName('txt_correo')[0].value == ''){
        
        alert('Todos los campos son requeridos');
        return;
    }
    
    
    if(special_chars.test(document.getElementsByName('txt_nombre')[0].value) 
    || special_chars.test(document.getElementsByName('txt_apellidos')[0].value) 
    || special_chars.test(document.getElementsByName('txt_telefono')[0].value) 
    || special_chars.test(document.getElementsByName('txt_correo')[0].value) ){
        
        alert('No se permite el uso de caracteres especiales');
        return;
    }
    
    if(document.getElementsByName('txt_nombre')[0].value.length > 50){
         
         alert('El Nombre no puede contener m\xE1s de 50 caracteres');
         return;
     }
    
    if(document.getElementsByName('txt_apellidos')[0].value.length > 50){
         
         alert('Los Apellidos no puede contener m\xE1s de 50 caracteres');
         return;
     }
     
//    if(!numero.test(document.getElementsByName('txt_cedula')[0].value)){
//    
//        alert('C\xE9dula no v\xE1lida');
//        return;
//    
//    }else if(cedulas.indexOf(document.getElementsByName('txt_cedula')[0].value.replace(/-/g, '')) != -1){
//        
//        alert('Esta C\xE9dula ya est\xE1 registrada en el torneo');        
//        return;
//        
//    }else if(document.getElementsByName('txt_cedula')[0].value.length > 50){
//        
//        alert('La C\xE9dula no puede contener  m\xE1s de 50 caracteres');
//        
//    }
    
    if(!numero.test(document.getElementsByName('txt_telefono')[0].value)){
        
        alert('Tel\xE9fono no v\xE1lido');        
        return;
        
    }else if(document.getElementsByName('txt_telefono')[0].value.length > 50){
        
        alert('El Tel\xE9fono no puede contener m\xE1s de 50 caracteres');
        return;
        
    }
    
    if(!correo.test(document.getElementsByName('txt_correo')[0].value)){
        
        alert('Correo no v\xE1lido');
        return;
    }else if(correos.indexOf(document.getElementsByName('txt_correo')[0].value) != -1){
        
        alert('Este Correo ya est\xE1 registrado en el torneo');        
        
        return;
    }else if(document.getElementsByName('txt_correo')[0].value.length > 50){
        
        alert('El Correo no puede contener m\xE1s de 50 caracteres');
        return;
        
    }
    
    lista = document.getElementById('registros');
    
    div = document.createElement('div');
    div.id = 'registro_' + registro;
    div.style.height = '24px';
    div.style.width = '320px';
    div.style.cssFloat = 'left';
    
    jugador = document.createElement('span');
    jugador.style.cssFloat = 'left';
   
    
    bola = document.createElement('img');
    bola.src = 'recursos/img/torneo/inscripcion/bola.png';
    
    borrar = document.createElement('span');
    borrar.style.cssFloat = 'right';
    
    eliminar = document.createElement('img');
    eliminar.src = 'recursos/img/torneo/inscripcion/eliminar.png';
    eliminar.style.cursor = 'pointer';
    eliminar.title = 'Eliminar';
    eliminar.alt = 'Eliminar';
    eliminar.setAttribute('onclick', 'document.getElementById(\'' + lista.id + '\').removeChild(document.getElementById(\'' + div.id + '\'));');
            
    data = document.createElement('input');
    data.type = 'hidden'
    data.name = 'datos';
    data.value = document.getElementsByName('txt_nombre')[0].value + ';'
        + document.getElementsByName('txt_apellidos')[0].value + ';'
        + '-;'
        + document.getElementsByName('txt_telefono')[0].value + ';'
        + document.getElementsByName('txt_correo')[0].value;
    
    nombre = document.createTextNode(' ' + document.getElementsByName('txt_nombre')[0].value + ' ' + document.getElementsByName('txt_apellidos')[0].value);
    
    jugador.appendChild(bola);
    jugador.appendChild(nombre);
    
    borrar.appendChild(eliminar);
    
    div.appendChild(jugador);
    div.appendChild(borrar);
    div.appendChild(data);
    
    this.lista.appendChild(this.div);
    
    //cedulas += document.getElementsByName('txt_cedula')[0].value.replace(/-/g, '') + ';';
    correos += document.getElementsByName('txt_correo')[0].value + ';';

    registro++;

    cancelar_registro();

}

function parse_jugadores(){
    
   jugadores = document.createElement('input');
   jugadores.type = 'hidden';
   jugadores.name = 'jugadores';
   jugadores.value = '';
   
    registros = document.getElementsByName('datos');
   
   for(i = 0; i < registros.length; i++){
       
       jugadores.value += registros[i].value + '|';
       
   }
   
   document.getElementById('equipo_jugadores').appendChild(jugadores);
    
}

function retrieve_jugadores(cadena){
    
    if(cadena != ''){
    
        lista = document.getElementById('registros');

        jugadores = cadena.split('|');

        for(i = 0; i < jugadores.length - 1; i++){

            div = document.createElement('div');
            div.id = 'registro_' + registro;
            div.style.height = '24px';
            div.style.width = '320px';
            div.style.cssFloat = 'left';

            jugador = document.createElement('span');
            jugador.style.cssFloat = 'left';

            bola = document.createElement('img');
            bola.src = 'recursos/img/torneo/inscripcion/bola.png';

            borrar = document.createElement('span');
            borrar.style.cssFloat = 'right';
            borrar.style.cursor = 'pointer';

            eliminar = document.createElement('img');
            eliminar.src = 'recursos/img/torneo/inscripcion/eliminar.png';
            eliminar.title = 'Eliminar';
            eliminar.alt = 'Eliminar';
            eliminar.onclick = function(){

                      eliminar.setAttribute('onclick', 'document.getElementById(\'' + lista.id + '\').removeChild(document.getElementById(\'' + div.id + '\'));');

                    };

            data = document.createElement('input');
            data.type = 'hidden'
            data.name = 'datos';
            data.value = jugadores[i];

            datos = jugadores[i].split(';');

            nombre = document.createTextNode(' ' + datos[0] + ' ' + datos[1]);
    
            jugador.appendChild(bola);
            jugador.appendChild(nombre);

            borrar.appendChild(eliminar);

            div.appendChild(jugador);
            div.appendChild(borrar);
            div.appendChild(data);

            this.lista.appendChild(this.div);

            //cedulas += datos[2].replace(/-/g, '') + ';';
            correos += datos[4] + ';';
            
            registro++;

        }
       
    }
   
}

function mostrar_reglamento(){
    
    if(document.getElementById('reglamento_torneo') == null){
    
        contenedor = document.getElementById('contenido');

        reglamento = document.createElement('div');
        reglamento.style.background = '#EEE';
        reglamento.style.borderRadius = '5px';
        reglamento.style.border = 'double 3px #000';
        reglamento.style.position = 'fixed';
        reglamento.style.height = '500px';
        reglamento.style.width = '350px';
        reglamento.style.fontFamily = 'arial, san-serif';
        reglamento.style.top = ((document.documentElement.clientHeight / 2) - 200) + 'px';
        reglamento.style.left = ((document.documentElement.clientWidth / 2) - 175) + 'px';
        reglamento.id = 'reglamento_torneo';

        cerrar = document.createElement('p');
        cerrar.style.padding = '0';
        cerrar.style.margin = '2px 3px';
        cerrar.style.fontStyle = '15px';
        cerrar.style.cssFloat = 'right';
        cerrar.style.cursor = 'pointer';
        cerrar.textContent = 'X';
        cerrar.onclick = function(){

                         contenedor.removeChild(reglamento);

                        };

        clear = document.createElement('div');
        clear.style.clear = 'both';

        contenido = document.createElement('div');
        contenido.style.height = '450px';
        contenido.style.textAlign = 'justify';
        contenido.style.padding = '0 10px';
        contenido.style.overflowY = 'auto';
        contenido.style.overflowX = 'hidden';

        p = document.createElement('p');
        p.textContent = document.getElementsByName('reglamento')[0].value.replace(/\\n/g, '\n');
        p.style.wordWrap = 'break-word';
        p.style.whiteSpace = 'pre-wrap';

        contenido.appendChild(p);

        reglamento.appendChild(cerrar);
        reglamento.appendChild(clear);
        reglamento.appendChild(contenido);

        contenedor.appendChild(reglamento);
        
    }
    
}
