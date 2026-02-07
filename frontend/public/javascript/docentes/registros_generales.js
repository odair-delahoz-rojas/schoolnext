document.addEventListener('DOMContentLoaded', function () {
  //console.clear();
});

function show_lista_estudiantes() {
  w3.show('#list_estudiantes');

  w3.hide('#list_index');
  w3.hide('#form_new');
  w3.hide('#form_edit');
}


function show_new_form(info_estudiante, estudiante_id, grado_id, salon_id, user_id) {
  var dt = new Date();
  const frm = document.getElementById("frm_new");
  document.getElementById("nombre_estud_new").innerHTML = info_estudiante;
  let ruta_new = document.getElementById('public_path').innerHTML.trim()+'admin/registros_gen/create_ajax';

  frm.registrosgens_estudiante_id.value = estudiante_id;
  frm.registrosgens_annio.value = dt.getFullYear();
  frm.registrosgens_grado_id.value = grado_id;
  frm.registrosgens_salon_id.value = salon_id;
  frm.registrosgens_created_by.value = user_id;
  frm.registrosgens_updated_by.value = user_id;
  frm.action = ruta_new;

  w3.show('#form_new');
  w3.hide('#list_index');
  w3.hide('#list_estudiantes');
  w3.hide('#form_edit');
}



function show_edit_form(reg_id, estudiante) {
  let ruta_load_data = document.getElementById('public_path').innerHTML.trim()+'api/registros_gen/singleid/'+reg_id;
  let ruta_edit = document.getElementById('public_path').innerHTML.trim()+'admin/registros_gen/edit_ajax/'+reg_id;
  
  fetch(ruta_load_data)
  .then((res) => res.json())
  .then(datos => {
    document.getElementById("nombre_estud_edit").innerHTML = estudiante;
    const frm = document.getElementById("frm_edit");
    
    frm.action = ruta_edit;
    frm.registrosgens_id.value = datos.id;
    frm.registrosgens_uuid.value = datos.uuid;
    frm.registrosgens_estudiante_id.value = datos.estudiante_id;
    frm.registrosgens_annio.value = datos.annio;
    frm.registrosgens_grado_id.value = datos.grado_id;
    frm.registrosgens_salon_id.value = datos.salon_id;
    frm.registrosgens_created_at.value = datos.created_at;
    frm.registrosgens_created_by.value = datos.created_by;
    frm.registrosgens_updated_at.value = datos.updated_at;
    frm.registrosgens_updated_by.value = datos.updated_by;
    
    frm.registrosgens_tipo_reg.value = datos.tipo_reg;
    frm.registrosgens_periodo_id.value = datos.periodo_id;
    frm.registrosgens_fecha.value = datos.fecha;
    frm.registrosgens_asunto.value = datos.asunto;

    frm.registrosgens_acudiente.value = datos.acudiente;
    frm.foto_acudiente.value = datos.foto_acudiente;
    frm.registrosgens_director.value = datos.director;
    frm.foto_director.value = datos.foto_director;
  })
  .catch(
    error => {
      //console.log(error);
      //document.getElementById("form_edit").innerHTML = error;
    }
  );
  w3.show('#form_edit');
  w3.hide('#list_index');
  w3.hide('#list_estudiantes');
  w3.hide('#form_new');
}


function cancelar() {
  w3.show('#list_index');
  
  w3.hide('#list_estudiantes');
  w3.hide('#form_new');
  w3.hide('#form_edit');
}