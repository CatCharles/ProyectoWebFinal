const formulario = document.querySelector('#select2_carrera');
formulario.addEventListener('change',leeFormulario);

const seriacionsubmit = document.querySelector('#agregarplanmateria');
seriacionsubmit.addEventListener('click',getError);

function leeFormulario(e){
    e.preventDefault();
    const id = document.querySelector('#select2_carrera').value;
    const tipo = '1';
    const datos = new FormData();
        datos.append('id',id);


        //llama a AJAX
        //crea objeto
        const xhr = new XMLHttpRequest();
        //abrir conexion
        xhr.open('GET',`servidor.php?id_carrera=${id}&tipo=${tipo}`,true);
        //recibe respuesta
        xhr.onload = function() {
            if(this.status===200){
                //console.log(xhr.responseText);
                const respuesta = JSON.parse(xhr.responseText);
                console.log("Esa :   "+respuesta);
                var mpos='';
               /// mpos = '<select>';
                for(var i=0;i<respuesta.length;i++){
                   // mpos += respuesta[i].nombre + '<br/>';

                   mpos += '<option value="'+respuesta[i].id+'"> ' +
                   respuesta[i].nombre + '</option>';
                   console.log(respuesta[i].query);
                }
                console.log("paso");
              //  mpos += '</select>';
                const div = document.querySelector('#select2_plan');
                
                div.innerHTML = mpos;
            }
            console.log("pasnoo");
        };
        //enviamos peticion
        xhr.send();
    }

function getError(e){
    e.preventDefault();  
    const id1 = document.querySelector('#select2_carrera').value;
    const id2 = document.querySelector('#select2_plan').value;
    const id3 = document.querySelector('#select2_materia').value;
    const id = id1.toString()+id2.toString()+id3.toString();
    const cuatrimestre = document.querySelector('#cuatrimestre').value;
    const creditos = document.querySelector('#creditos').value;
    const practicas = document.querySelector('#practicas').value;
    const teoricas = document.querySelector('#teoricas').value;

    const tabla ='planes_con_materias';
    const tipo ='2';
    console.log("mi id: " + id);
    const datos = new FormData();
        datos.append('id',id);
    //llama a AJAX
        //crea objeto
        const xhr = new XMLHttpRequest();
        //abrir conexion
        xhr.open('GET',`servidor.php?id_error=${id}&tabla=${tabla}&tipo=${tipo}&cuatrimestre=${cuatrimestre}&creditos=${creditos}&practicas=${practicas}&teoricas=${teoricas}`,true);

        xhr.onload = function(){
            if (this.status == 200) {
                var respuesta = '';
                var mpos='';
                const modal1 = document.querySelector('#myModal');
                console.log(xhr.responseText +   "  arriba");
                respuesta = (xhr.responseText);
                if(respuesta == "true"){
                    console.log("no mostrrar nada");
                    console.log(xhr.responseText + " cathy");
                    location.href="planesconmaterias.php";
                }else{
                     console.log(xhr.responseText + " abajo");
                    $("#myModal").modal('show');
                    $(".modal-title").text("Advertencia");
                    $(".modal-body").text("Esta materia ya ha sido añadida a este plan de estudio.");

                }
            }
        };

        //enviamos peticion
        xhr.send();
}