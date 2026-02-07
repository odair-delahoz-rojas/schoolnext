document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
});

function traer_data(estudiante_id, salon_nombre, periodo) {
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  console.clear();

  // ========================================================================      
  const div_info_estudiante = document.getElementById("info_estudiante");
  fetch(ruta_base+'api/estudiantes/singleid/'+estudiante_id)
  .then((res) => res.json())
  .then(data_estudiante => {

    div_info_estudiante.innerHTML = template_datos_estud(data_estudiante, ruta_base, salon_nombre);
    
    // LINKS PARA DESCARGAR PREINFORMES
    const periodo_preinformes = document.getElementById('periodo_preinformes').value;
    div_preinformes = document.getElementById('preinformes');
    if (1==document.getElementById('ver_preinformes').value) {
      div_preinformes.innerHTML = template_preinformes(data_estudiante, ruta_base, periodo_preinformes);
    }

    // LINKS PARA DESCARGAR BOLETINES
    const periodo_boletines = document.getElementById('periodo_boletines').value;
    div_boletines = document.getElementById('boletines');
    if (1==document.getElementById('ver_boletines').value) {
      div_boletines.innerHTML = template_boletines(data_estudiante, ruta_base, periodo_boletines);
    }


    /// matriculas
    const div_matriculas = document.getElementById('proceso_matriculas');
    if ( 1==document.getElementById('ver_matriculas').value && 1==data_estudiante.is_active ) { 
      const arr_estado_mat = [
        '[0] Bloqueado x Contabilidad',
        '[1] No ha subido Documentos',
        '[2] Documentos INCOMPLETOS',
        '[3] Documentos EN REVISIÓN',
        '[4] Documentos RECHAZADOS',
        '[5] Documentos APROBADOS, Falta Asignar Número de Matrícula',
        '[6] Documentos APROBADOS, Faltan FIRMAS del Acudiente',
        '[7] Proceso Terminado',
      ];

      let estado_mat = '';
      if ( data_estudiante.mes_pagado!=11 || data_estudiante.is_debe_preicfes==1  || data_estudiante.is_debe_almuerzos==1 ) {
        estado_mat = `
          <div class="w3-panel w3-pale-red w3-leftbar w3-border-red">
            <p>Estado del proceso:${arr_estado_mat[0]}</p>
          </div>
        `;
      } else {
        estado_mat = `
          <div class="w3-panel w3-pale-blue w3-leftbar w3-border-blue">
            <p>Estado del proceso:${arr_estado_mat[1]}</p>
          </div>
          ${links_decargas_matricula()}
          <br><br>
          <div class="w3-display-container">
            <div class="w3-display-left w3-small">
            ¿Requiere Soporte Técnico? <a title="Escríbenos" href="whatsapp://send?phone=+573017153066&amp;text=Requiero+soporte+técnico">
            <i class="fa-brands fa-whatsapp w3-xlarge" aria-hidden="true"></i> </a>
            </div>
          </div>          
        `;
      }

      let link_matriculas = ruta_base+'padres/matriculas';
      div_matriculas.innerHTML = `
      <div>
        <h2 class="w3-panel w3-theme w3-round-xlarge">Proceso de Matrículas 2025</h2>
        <a href="${link_matriculas}" class="w3-btn w3-blue"> Ir a Módulo de Matrículas</a>
      </div>`;
    }

  });
  

  

  // ========================================================================      
  const periodo_seguimientos = document.getElementById('periodo_seguimientos').value;
  const div_seguimientos = document.getElementById('seguimientos');

  if (1==document.getElementById('ver_seguimientos').value) { 
    getDataSeguimientos(ruta_base, estudiante_id, periodo_seguimientos)
    .then(res => {
      const elements = res.reduce((acc, data_seguimientos) => acc + template_seguimientos(ruta_base, data_seguimientos), "");
      const botones = elements;
      if (botones.length>0) { 
        div_seguimientos.innerHTML = `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Seguimientos Intermedios</h2>
          ${botones}
        </div>`;
      } else { 
        div_seguimientos.innerHTML =  `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Seguimientos</h2>
          <span class="w3-text-blue">No tiene Seguimientos en el presente periodo</span>
        </div>`; 
      }
    });
  } //END-if
  
  function getDataSeguimientos(ruta_base, estudiante_id, periodo_id) {
    ruta = ruta_base+'api/seguimientos/by_estudiante_periodo/'+estudiante_id+'/'+periodo_id;
    return fetch(ruta).then(res => res.json() );
  }//END-getDataSeguimientos

  function template_seguimientos(ruta_base, data) {
    let ruta_descarga_seguimientos  = ruta_base+'admin/seguimientos/exportSeguimientosRegistroPdf/'+data.uuid;
    //console.log('periodo: '+data.periodo_id);
    return `
      <a href="${ruta_descarga_seguimientos}" 
        class="w3-btn w3-black" 
        target="_blank">
        <i class="fa-solid fa-file-pdf"></i> ${data.asignatura_nombre} P${data.periodo_id}
      </a>
    `;
  } //END-template_seguimientos



  // ========================================================================      
  const periodo_planes_apoyo = document.getElementById('periodo_planes_apoyo').value;
  const div_planes_apoyo = document.getElementById('planes_apoyo');

  if (1==document.getElementById('ver_planes_apoyo').value) { 
    getDataPlanesApoyo(ruta_base, estudiante_id, periodo_planes_apoyo)
    .then(res => {
      const elements = res.reduce((acc, data_planes_apoyo) => acc + template_planes_apoyo(ruta_base, data_planes_apoyo), "");
      const botones = elements;

      if (botones.length>0) { 
        div_planes_apoyo.innerHTML = `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Planes de Apoyo</h2>
          ${botones}
        </div>`;
      } else { 
        div_planes_apoyo.innerHTML =  `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Planes de Apoyo</h2>
          <span class="w3-text-blue">No tiene Planes de Apoyo en el presente periodo</span>
        </div>`; 
      }
    });
  } //END::PLANES-DE-APOYO 
  

} //END-traer_data



function template_proceso_matriculas(data, ruta) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Proceso de Matrículas</h2>
  `;
} //END-template_proceso_matriculas




function getDataPlanesApoyo(ruta_base, estudiante_id, periodo_id) 
{
  ruta = ruta_base+'api/planes_apoyo/by_estudiante_periodo/'+estudiante_id+'/'+periodo_id;
  return fetch(ruta).then(res => res.json() );
}


function template_planes_apoyo(ruta_base, data) 
{
  let ruta_descarga_plan_apoyo  = ruta_base+'admin/planes_apoyo/exportPlanesApoyoRegistroPdf/'+data.uuid;
  //console.log('periodo: '+data.periodo_id);
  return `
    <a href="${ruta_descarga_plan_apoyo}" 
       class="w3-btn w3-black" 
       target="_blank">
       <i class="fa-solid fa-file-pdf"></i> ${data.asignatura_nombre} P${data.periodo_id}
    </a>
  `;
}


function template_datos_estud(data, ruta, salon_nombre) 
{
  let estado = (data.is_active==1) ? 'ACTIVO' : 'INACTIVO';
  let debe_almuerzos = (data.is_debe_almuerzos>0) ? 'SI' : 'NO';
  let debe_preicfes = (data.is_debe_preicfes>0) ? 'SI' : 'NO';
  let domain_name = document.getElementById('domain_name').innerHTML.trim();
  let instit = document.getElementById('instit').innerHTML.trim();
  
  const cuenta = instit=='windsor' ? data.email_instit+'@'+domain_name : data.email_instit;

  return `
  <div class="w3-card-1">

    <header class="w3-container w3-light-blue  w3-round-xlarge">
      <h2 class="w3-round-xlarge">${data.nombres} ${data.apellido1} ${data.apellido2} [${salon_nombre}]</h2>
    </header>

    <div class="w3-container">
      <div class="w3-row">
        <div class="w3-col l6 m7 s12">
          <br>
          Estado: ${estado}
          <br><br>
          Cuenta Externa:
          <br>
          <span class="w3-text-blue">${cuenta}</span>
          <br>
          Clave de Acceso: <span class="w3-text-blue">${data.clave_instit}</span>
        </div>

        <div class="w3-col l6 m7 s12">
          <br>
          Último Pago: Mes ${nombreMes(data.mes_pagado)} de ${data.annio_pagado}
          <br>
          <br>
          Debe Almuerzos: ${debe_almuerzos} 
          <br>
          Debe Preicfes: ${debe_preicfes} 
        </div>
      </div>
    </div>

    <footer class="w3-container">
    </footer>

  </div>
  `;
} //END-template_datos_estud


function template_seguimientos(data, ruta) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Seguimientos Intermedios</h2>
  `;
} //END-template_seguimientos


function template_preinformes(estudiante, ruta_base, periodo_actual) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Preinformes</h2>
    <a href="${ruta_base}admin/notas/exportPreinformeEstudiantePdf/${periodo_actual}/${estudiante.uuid}" 
      class="w3-btn w3-blue" alt="Descarga PDF" target="_blank"><i class="fa-solid fa-file-pdf"></i> Preinforme p${periodo_actual}</a>
  `;
} //END-template_preinformes


function template_boletines(estudiante, ruta_base, periodo_actual) {
  let annio_actual = document.getElementById('annio_actual').innerHTML.trim();
  let links = '';
  let mes_req = [];
  mes_req[1] = 3;
  mes_req[2] = 6;
  mes_req[3] = 8;
  mes_req[4] = 11;
  mes_req[5] = 11;
  let max_periodo = (4==periodo_actual) ? 5 : periodo_actual;
  for (var i= 1; i<=max_periodo; i++) {
    if ( (estudiante.mes_pagado >= mes_req[i]) && (estudiante.annio_pagado == annio_actual) ) {
      links +=  `
      <a href="${ruta_base}admin/notas/exportBoletinEstudiantePdf/${i}/${estudiante.uuid}" 
      class="w3-btn w3-blue" alt="Descarga PDF" target="_blank"><i class="fa-solid fa-file-pdf"></i> Boletin p${i}</a>
      `;
    } else {
      links +=  `
      <span class="w3-btn w3-grey" title="bloqueado"> <i class="fa-solid fa-file-pdf"></i> Boletin p${i} </span>
      `;
    }
  }
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Boletines</h2>
    ${links}
  `;
} //END-template_boletines


function template_reconocimientos(data, ruta_base) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Reconocimientos</h2>
  `;
} //END-template_reconocimientos


function nombreMes(mes) {
  const meses = ["Mes Indefinido", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  return meses[mes];
}

function links_decargas_matricula () {
  let ruta_base = document.getElementById('public_path').innerHTML.trim()+'files/download/matriculas/';
  let msg_links_docs =  `
    <h5>DESCARGAR DOCUMENTOS DE MATRÍCULA<h5>
    <p class="w3-panel w3-pale-yellow w3-border w3-border-yellow"><small>Debe descargar estos documentos, diligenciarlos y escanearlos en formato pdf cada uno por aparte, para luego subirlos junto con el recibo de pago de la matrícula</small></p>
    <table>
      <tr>
        <td>Pagaré</td>
        <td><a href="${ruta_base}windsor_formato_pagare.pdf" class="w3-btn w3-pale-green w3-round" target="_blank"><i class="fa-solid fa-file-pdf"></i> Pagaré</a></td>
      </tr>
      <tr>
        <td>Instrucciones pagaré</td>
        <td><a href="${ruta_base}windsor_formato_instruccion_pagare.pdf" class="w3-btn w3-pale-green w3-round" target="_blank"><i class="fa-solid fa-file-pdf"></i> Instrucción Pagaré</a></td>
      </tr>
      <tr>
        <td>Actualización de datos y autorización</td>
        <td><a href="${ruta_base}windsor_formato_actualizacion.pdf" class="w3-btn w3-pale-green w3-round" target="_blank"><i class="fa-solid fa-file-pdf"></i> Actualización</a></td>
      </tr>
      <tr>
        <td>formulario SIMPADE, Min de Educación</td>
        <td><a href="${ruta_base}windsor_formulario_simpade_2024.pdf" class="w3-btn w3-pale-green w3-round" target="_blank"><i class="fa-solid fa-file-pdf"></i> SIMPADDE 2024</a></td>
      </tr>
    </table>
 
  `;
  return msg_links_docs;

}
