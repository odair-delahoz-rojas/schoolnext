
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
  document.querySelector('#spinner').style.display = "none";
});

function traer_data_reg_gen(salon_id, salon_nombre, annio) {
  console.clear();
  let ruta = document.getElementById('public_path');
  document.getElementById('resultados').innerHTML = '';
  document.querySelector('#spinner').style.display = "block";

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
      for (let key in datos)
      {
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
      document.querySelector('#spinner').style.display = "none";
  })
  .catch(
      error => console.log('ERROR traer_data'+error)
  );

}