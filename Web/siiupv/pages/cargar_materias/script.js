//const opcion = document.querySelector('#Algoritmos');

//opcion.addEventListener('click',clases);

$tabla = '';
let respuesta = '';
let element = '';


function cargarDatos(e, clave, id_grupo, id_carrera, id_plan, id_materia, id_maestro, cuatri, alumno){
    //e.preventDefault();    
    const id = e.id;
    console.log(e);
    element = e;
    //let id = e.id;
    //console.log('id_clase: '+id);
    //console.log('Clave: '+clave);
    //console.log('id_grupo: '+id_grupo);
    //console.log('id_carrera: '+id_carrera);
    //console.log('id_plan: '+id_plan);
    //console.log('id_materia: '+id_materia);
    //console.log('id_maestro: '+id_maestro);
    //console.log('Cuatrimestre: '+cuatri);
    //console.log(opcion);
    //const tabla = 'grupos';
    //const tipo = '1';
    const datos = new FormData();
        datos.append('id',id);        
        
        //llama a AJAX
        //crea objeto
        const xhr = new XMLHttpRequest();
        //abrir conexion
        xhr.open('GET',"servidor.php?id="+id
            +"&clave="+clave
            +"&id_grupo="+id_grupo
            +"&id_carrera="+id_carrera
            +"&id_plan="+id_plan
            +"&id_materia="+id_materia
            +"&id_maestro="+id_maestro
            +"&cuatri="+cuatri
            +"&tipo=1",true);
        //console.log(`servidor.php?id_carrera=${id}&tabla=${tabla}`);
        //recibe respuesta
        xhr.onload = function() {
            if(this.status===200){                
                var mpos='';
                respuesta = '';
                const div = document.querySelector('#mvalues');
                //console.log("div " + div);
                //try {
                    //console.log("Respuestas");
                   //console.log(xhr.responseText);
                    respuesta = JSON.parse(xhr.responseText);
                                        
                    mpos += '<tr>';
                    for(var i=0;i<respuesta.length;i++){                        
                        mpos += '<td id=\"'+i+'\">'+respuesta[i].cve_clase+'</td>';
                        mpos += '<td>'+respuesta[i].profesor+'</td>';
                        mpos += '<td>'+respuesta[i].lun+'</td>';
                        mpos += '<td>'+respuesta[i].mar+'</td>';
                        mpos += '<td>'+respuesta[i].mie+'</td>';
                        mpos += '<td>'+respuesta[i].jue+'</td>';
                        mpos += '<td>'+respuesta[i].vie+'</td>';
                        mpos += '<td>'+respuesta[i].cap+'</td>';
                        mpos += '<td><label class=\"radio\"><input type=\"radio\" value=\"'+i+'\"></label></td>';
                    }
                    mpos += '</tr>';

                    //botonEliminar(id, alumno);
  
                    div.innerHTML = mpos;
                //} catch(error) {                
                //    console.log(error);
                //    div.innerHTML = mpos;
                //}     
            }
        };        

        //enviamos peticion
        xhr.send();
}

function botonEliminar(id_clase,id_alumno){

   //let data = $('input[type="radio"]:checked').val();
   //console.log("Valor "+respuesta[data].id_clase);
   // MODIFICAR TIPO FIJO.
   const xhr = new XMLHttpRequest();
   xhr.open('GET',"servidor.php?id_clase="+id_clase+"&id_alumno="+id_alumno+"&tipo=3",true);
   xhr.onload = function() {
      if(this.status===200){

        var mpos='';
        respuesta = '';       

        const div = document.querySelector('#eliminar');
        //console.log("div " + div);
        try {
            //console.log("Respuestas");
            console.log(xhr.responseText);
            respuesta = JSON.parse(xhr.responseText);
            
            mpos += '';
            console.log("Respuesta: "+respuesta[0].respuesta);
            if(respuesta[0].respuesta == '1') {
               console.log("entra en eliminar");
               mpos += '<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>';
               mpos += '<button type="button" onclick="eliminarClase('+id_alumno+')" class="btn btn-danger" data-dismiss="modal">Eliminar</button>';
            } else {
               mpos += '<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>';
               mpos += '<button type="button" onclick="leerDatos('+id_alumno+')" class="btn btn-default" data-dismiss="modal">Guardar cambios</button>';
            }            


            div.innerHTML = mpos;            
        } catch(error) {                
            console.log(error);
            div.innerHTML = mpos;
        }     
      }
   }
   //enviamos peticion
   xhr.send();

}


function leerDatos(id_alumno, id_clase){

   let data = $('input[type="radio"]:checked').val();
   console.log("Valor "+respuesta[data].id_clase);
   // MODIFICAR TIPO FIJO.
   const xhr = new XMLHttpRequest();
   xhr.open('GET',"servidor.php?id_clase="+respuesta[data].id_clase+"&id_alumno="+id_alumno+"&tipo=2",true);
   xhr.onload = function() {
      if(this.status===200){

        var mpos='';
        respuesta = '';

        console.log(element);

        element.setAttribute("class","btn btn-warning");

        const div = document.querySelector('#materias_carrera');
        //console.log("div " + div);
        //try {
            //console.log("Respuestas");
           //console.log(xhr.responseText);
            //respuesta = JSON.parse(xhr.responseText);
            
            //mpos += '<tr>';
            /*for(var i=0;i<respuesta.length;i++){                        
                mpos += '<td id=\"'+i+'\">'+respuesta[i].cve_clase+'</td>';
                mpos += '<td>'+respuesta[i].profesor+'</td>';
                mpos += '<td>'+respuesta[i].lun+'</td>';
                mpos += '<td>'+respuesta[i].mar+'</td>';
                mpos += '<td>'+respuesta[i].mie+'</td>';
                mpos += '<td>'+respuesta[i].jue+'</td>';
                mpos += '<td>'+respuesta[i].vie+'</td>';
                mpos += '<td>'+respuesta[i].cap+'</td>';
                mpos += '<td><label class=\"radio\"><input type=\"radio\" value=\"'+i+'\"></label></td>';
            }*/
            
            //mpos += '</tr>';


        //div.innerHTML = mpos;
        //} catch(error) {                
        //    console.log(error);
        //    div.innerHTML = mpos;
        //}     
      }
   }
   //enviamos peticion
   xhr.send();

}


