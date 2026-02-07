
document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('btn-1').click();
});



function show_edit_form(id) {
  w3.hide('#form_new');
  w3.hide('#list_index');
  
  const public_path = document.getElementById('public_path').innerHTML.trim();
  let ruta = public_path+'api/indicadores/singleid/'+id;
  fetch(ruta)
  .then((res) => res.json())
  .then(datos => {
    const frm = document.getElementById("frm_edit");
    const titulo = document.getElementById("titulo").innerHTML;

    frm.action = public_path + 'admin/indicadores/edit_ajax/'+id+'/docentes.listIndicadores.'+datos.grado_id+'.'+datos.asignatura_id;
    
    document.getElementById("titulo_indicador_edit").innerHTML = `Editando Indicador: ${datos.id} <br>${titulo} <br>${datos.valorativo} - ${datos.codigo}`;
    

    frm.indicadors_id.value             = datos.id;
    frm.indicadors_annio.value          = datos.annio;
    frm.indicadors_periodo_id.value     = datos.periodo_id;
    frm.indicadors_grado_id.value       = datos.grado_id;
    frm.indicadors_asignatura_id.value  = datos.asignatura_id;

    frm.indicadors_codigo.value         = datos.codigo;
    frm.indicadors_concepto.value       = datos.concepto;
    frm.indicadors_valorativo.value     = datos.valorativo;
    frm.indicadors_is_visible.value     = datos.is_visible;
    frm.indicadors_is_active.value      = datos.is_active;
    
    frm.indicadors_created_at.value     = datos.created_at;
    frm.indicadors_created_by.value     = datos.created_by;
  })
  .catch(
    error => {
      console.log(error);
    }
  );
  
  w3.show('#form_edit');
}//END-show_edit_form



function show_new_form(periodo_id, grado_id, asignatura_id) {
  w3.hide('#form_edit');
  w3.hide('#list_index');
  const public_path = document.getElementById('public_path').innerHTML.trim();
  
  var dt = new Date();
  const frm = document.getElementById("frm_new");
  // 'annio', 'periodo_id', 'grado_id', 'asignatura_id', 
  // 'codigo', 'concepto', 'valorativo', 'is_visible', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'
  document.getElementById("titulo_indicador_new").innerHTML = 'Nuevo Indicador';
  
  frm.action = public_path + "admin/indicadores/create_ajax/"+'docentes.listIndicadores.'+grado_id+'.'+asignatura_id;
  frm.indicadors_annio.value = dt.getFullYear();
  frm.indicadors_periodo_id.value    = periodo_id;
  frm.indicadors_grado_id.value      = grado_id;
  frm.indicadors_asignatura_id.value = asignatura_id;
  frm.indicadors_codigo.value        = '';
  frm.indicadors_concepto.value      = '';
  frm.indicadors_valorativo.value    = 'Fortaleza';
  
  frm.indicadors_is_visible.value = 1;
  frm.indicadors_is_active.value  = 1;
  
  w3.show('#form_new');
}//END-show_new_form

function cancelar() {
  w3.show('#list_index');
  w3.hide('#form_new');
  w3.hide('#form_edit');
}//END-cancelar

function traer_data(periodo_id, grado_id, asignatura_id) {
  const capa_datos = document.getElementById("capa_datos");
  getData(periodo_id, grado_id, asignatura_id).then(res => {
    const elements = res.reduce((acc, data) => acc + template(data, periodo_id, grado_id, asignatura_id), "");
    const boton_add = `
    <div class="w3-panel">
      <button 
        class="w3-button w3-round w3-green" 
        onclick="show_new_form(${periodo_id}, ${grado_id}, ${asignatura_id})" 
        title="Agregar Nuevo Indicador en Periodo P${periodo_id}">
          Agregar Indicador P${periodo_id}
      </button>
    </div>`;
    const tabla = boton_add
          + `<table id="myTable" class="w3-table w3-responsive w3-striped w3-border w3-bordered">
        <tbody id="searchBody"></tbody>
          ${elements}
      </table>
    `;

    capa_datos.innerHTML = tabla;
    if (res.length==0) {
      capa_datos.innerHTML = boton_add + '<br>No hay registros para mostrar';
    }
  });
} //END-traer_data

function template(data, periodo_id, grado_id, asignatura_id) {
  let ruta_delete = document.getElementById('public_path').innerHTML.trim()+'admin/indicadores/del/';
  let ruta_edit   = document.getElementById('public_path').innerHTML.trim()+'admin/indicadores/edit_ajax/';
  
  href_delete = ruta_delete + data.id +'/docentes.listIndicadores.' +grado_id +'.' +asignatura_id;
  href_edit   = ruta_edit + data.id +'/docentes.listIndicadores.' +grado_id +'.' +asignatura_id;
  indicador_codigo = 'P'+data.periodo_id + '-' +data.codigo + ' ['+ data.valorativo +']';
  return `
    <tr class="item w3-theme-d4">
      <td id="${data.id}"> 
        <a href="${href_delete}" onclick="return confirm('Atención: ¿Quiere borrar Indicador ${data.codigo}?')">
        <i class="fa-solid fa-trash-can w3-large"></i></a>
        <b>${indicador_codigo}</b>
        <br>
        <p class="w3-hover-text-blue" title="EDITAR Indicador ${indicador_codigo}" onclick="show_edit_form(${data.id})">${data.concepto}</p>
      </td>
    </tr>
  `;
}//END-template

function getData(periodo_id, grado_id, asignatura_id) {
  let ruta = document.getElementById('public_path').innerHTML.trim()+'api/indicadores/list/'+periodo_id+'/'+grado_id+'/'+asignatura_id;
  return fetch(ruta).then(res =>
    res.json()
  );
}//END-getData
