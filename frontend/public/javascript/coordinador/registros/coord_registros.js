
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
});


function traer_salones(user_id, annio) {
  document.querySelector('#salones').innerHTML = '';
  document.querySelector('#resultados').innerHTML = '';

  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  let url = ruta_base+`api/notas/salones_coordinador_by_annio/${user_id}/${annio}`;
  fetch(url)
  .then((res) => res.json())
  .then(datos => {
    let html = `
      <h2>SALONES (AÑO ${annio})</h2>
      <div class="w3-bar">
    `;
    for (let key in datos) {
      html += `<div class=\"w3-bar-item\">
                  <button 
                    id="salon-${key}" 
                    onclick="cargar_botones(${datos[key].salon_id}, '${datos[key].salon_nombre}', ${annio})" 
                    class="w3-bar-item">
                    ${datos[key].salon_nombre}
                  </button>
                </div>`;
    }
    html += '</div>';
    document.querySelector('#salones').innerHTML = html;
    document.getElementById('salon-0').click();

  })
    .catch(
        error => document.querySelector('#salones').innerHTML = 'ERROR traer_salones:'+error
    );
} //END-traer_salones



function cargar_botones(salon_id, salon_nombre, annio, max_periodos) {
  let ruta = document.getElementById('public_path');
  document.getElementById('botones').innerHTML = '';

  btn_reg_gen = `
    <button 
      id="btn-reg-gen" 
      onclick="traer_data_reg_gen(${salon_id}, '${salon_nombre}', ${annio})" 
      class="w3-bar-item">
        Registros Generales ${salon_nombre}
      </button>
  `;

  btn_reg_acad = `
    <button 
      id="btn-reg-acad" 
      onclick="traer_data_reg_acad(${salon_id}, '${salon_nombre}', ${annio})" 
      class="w3-bar-item">
      Registros Academicos ${salon_nombre}
      </button>
  `;

  document.getElementById('botones').innerHTML = `<div class=\"w3-bar-item\"> ${btn_reg_gen} ${btn_reg_acad} </div>`;
  document.getElementById('btn-reg-gen').click();

}



function traer_data_reg_gen(salon_id, salon_nombre, annio) {
  console.clear();
  let ruta = document.getElementById('public_path');
  document.getElementById('resultados').innerHTML = '';

  // 1. registros generales
  fetch(ruta.innerHTML.trim()+`api/registros_gen/reg_observ_annio_salon/${annio}/${salon_id}`)
    .then((res) => res.json())
    .then(datos => {
      let plantilla_tabla = `
      <table id="myTable" class="w3-table w3-responsive w3-bordered">

        <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">
          TEXTCAPTION
        </caption>
        
        <tbody id="tbody">
          TEXTBODY
        </tbody>

      </table>
      `;
      let output = '';
      let caption = '';
      for (let key in datos) {
        color = (('ACAD'==datos[key].tipo_reg) ? 'w3-teal' : 'w3-red');
        texto_tipo_reg = (('ACAD'==datos[key].tipo_reg) ? 'ACADÉMICO' : 'DISCIPLINARIO');
        output += `
          <tr> 
            <td style="width:65%">
              <h3>${datos[key].estudiante_nombre}</h3>
              <span class="w3-tag w3-round ${color} w3-border w3-border-white">${texto_tipo_reg}</span>
              <br> ${datos[key].asunto}
            </td>
            <td style="width:35%">
              <b>Periodo ${datos[key].periodo_id}</b>  [${datos[key].fecha}]<br><br>
              <b>Docente:</b> <br> ${datos[key].director}<br><br>
              <b>Acudiente:</b> <br> ${datos[key].acudiente}
            </td>
          </tr>
        `;
      }
      let salida = plantilla_tabla.replace('TEXTCAPTION', `REGISTROS GENERALES ${salon_nombre}`);
      document.getElementById('resultados').innerHTML = salida.replace('TEXTBODY', output);
  })
  .catch(
      error => console.log('ERROR traer_data'+error)
  );

}// end-traer_data_reg_gen


// 2. registros academicos
function traer_data_reg_acad(salon_id, salon_nombre, annio) {
  // `fortalezas`, `dificultades`, `compromisos`, `fecha`, `acudiente`, `foto_acudiente`, `director`, `foto_director`,
  console.clear();
  let ruta = document.getElementById('public_path');
  document.getElementById('resultados').innerHTML = '';

  fetch(ruta.innerHTML.trim()+`api/registros_desemp_acad/reg_observ_annio_salon/${annio}/${salon_id}`)
    .then((res) => res.json())
    .then(datos => {
      let plantilla_tabla = `
      <table id="myTable" class="w3-table w3-responsive w3-bordered">

        <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">
          TEXTCAPTION
        </caption>
        
        <tbody id="tbody">
          TEXTBODY
        </tbody>

      </table>
      `;
      let output = '';
      let caption = '';
      for (let key in datos) {
        output += `
          <tr> 
            <td style="width:65%">
              <h3>${datos[key].estudiante_nombre}</h3>
              <b>Fortalezas:</b> <br> ${datos[key].fortalezas}<br>
              <b>Dificultades:</b> <br> ${datos[key].dificultades}<br>
              <b>Compromisos:</b> <br> ${datos[key].compromisos}
            </td>
            <td style="width:35%">
              <b>Periodo ${datos[key].periodo_id}</b>  [${datos[key].fecha}]<br><br>
              <b>Docente:</b> <br> ${datos[key].director}<br><br>
              <b>Acudiente:</b> <br> ${datos[key].acudiente}
              </td>
          </tr>
        `;
      }
      let salida = plantilla_tabla.replace('TEXTCAPTION', `REGISTROS DE DESEMPEÑO ACADEMICOS ${salon_nombre}`);
      document.getElementById('resultados').innerHTML = salida.replace('TEXTBODY', output);
  })
  .catch(
      error => console.log('ERROR traer_data'+error)
  );

}// end-traer_data_reg_acad