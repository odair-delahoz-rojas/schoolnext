
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
                    onclick="traer_data(${datos[key].salon_id}, '${datos[key].salon_nombre}', ${annio}, ${datos[key].max_periodos})" 
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


function traer_data(salon_id, salon_nombre, annio, max_periodos) {
  console.clear();
  let ruta = document.getElementById('public_path');
  document.getElementById('resultados').innerHTML = '';

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
        output += `
          <tr> 
            <td>P${datos[key].periodo_id}<br>${datos[key].fecha}</td>
            <td>${datos[key].estudiante_nombre}</td>
            <td>${datos[key].tipo_reg}</td>
            <td>${datos[key].asunto}</td>
            <td>Director:<br>  ${datos[key].director}</td>
            <td>Acudiente:<br> ${datos[key].acudiente}</td>
          </tr>
        `;
      }
      let salida = plantilla_tabla.replace('TEXTCAPTION', `REGISTROS GENERALES ${salon_nombre}`);
      document.getElementById('resultados').innerHTML = salida.replace('TEXTBODY', output);
  })
  .catch(
      error => console.log('ERROR traer_data'+error)
  );

}