document.addEventListener('DOMContentLoaded', function () {
  //console.clear();
});

function show_lista_estudiantes() {
  w3.show('#list_estudiantes');

  w3.hide('#list_index');
  w3.hide('#form_new');
  w3.hide('#form_edit');
}

function show_new_form(estudiante_nombre, estudiante_id, grado_id, salon_id, user_id) {
  var dt = new Date();
  const frm = document.getElementById("frm_new");
  document.getElementById("nombre_estud_new").innerHTML = estudiante_nombre;
  frm.registrodesempacads_estudiante_id.value = estudiante_id;
  frm.registrodesempacads_annio.value = dt.getFullYear();
  frm.registrodesempacads_grado_id.value = grado_id;
  frm.registrodesempacads_salon_id.value = salon_id;
  frm.registrodesempacads_created_by.value = user_id;
  frm.registrodesempacads_updated_by.value = user_id;

  w3.show('#form_new');

  w3.hide('#list_index');
  w3.hide('#list_estudiantes');
  w3.hide('#form_edit');
}


function show_edit_form(reg_id, estudiante) {
  console.clear();
  let ruta_load_data = document.getElementById('public_path').innerHTML.trim()+'api/registros_desemp_acad/singleid/'+reg_id;
  let ruta_edit = document.getElementById('public_path').innerHTML.trim()+'admin/registros_desemp_acad/edit_ajax/'+reg_id;

  fetch(ruta_load_data)
  .then((res) => res.json())
  .then(datos => {
    document.getElementById("nombre_estud_edit").innerHTML = estudiante;
    console.log(datos);
    const frm = document.getElementById("frm_edit");
  
    frm.action = ruta_edit;
    frm.registrodesempacads_id.value = datos.id;
    frm.registrodesempacads_uuid.value = datos.uuid;
    frm.registrodesempacads_estudiante_id.value = datos.estudiante_id;
    frm.registrodesempacads_annio.value = datos.annio;
    frm.registrodesempacads_grado_id.value = datos.grado_id;
    frm.registrodesempacads_salon_id.value = datos.salon_id;
    frm.registrodesempacads_created_at.value = datos.created_at;
    frm.registrodesempacads_created_by.value = datos.created_by;
    frm.registrodesempacads_updated_at.value = datos.updated_at;
    frm.registrodesempacads_updated_by.value = datos.updated_by;
    
    frm.registrodesempacads_periodo_id.value = datos.periodo_id;
    frm.registrodesempacads_fecha.value = datos.fecha;
    frm.registrodesempacads_fortalezas.value = datos.fortalezas;
    frm.registrodesempacads_dificultades.value = datos.dificultades;
    frm.registrodesempacads_compromisos.value = datos.compromisos;

    frm.registrodesempacads_acudiente.value = datos.acudiente;
    frm.foto_acudiente.value = datos.foto_acudiente;
    frm.registrodesempacads_director.value = datos.director;
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