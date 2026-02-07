document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
});

function traer_salones(periodo, coordinador) {
  //console.clear();
  document.getElementById('salones').innerHTML = '';

  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  let url = ruta_base+`api/salones/by_coordinador/${coordinador}`;  // cambiarlo por salones_por_coordinador
  fetch(url)
  .then((res) => res.json())
  .then(datos => {
    let html = `<div class="w3-bar">`;
    for (let key in datos) { 
      html += `<div class=\"w3-bar-item\">
                  <button id="salon-${key}" onclick="traer_data('${datos[key].nombre}', '${datos[key].uuid}', ${periodo})" class="w3-bar-item">
                    ${datos[key].nombre}
                  </button>
                </div>`;
    }
    html += '</div>';
    document.getElementById('salones').innerHTML = html;
    document.getElementById('salon-0').click();
  })
    .catch(
        error => document.querySelector('#resultados').innerHTML = error
    );
} //END-traer_salones


function traer_data(salon_nombre, salon_uuid, periodo) {
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  let theme = document.getElementById('theme').innerHTML.trim();
  document.querySelector('#resultados').innerHTML = '';
  
  //console.clear();
  fetch(ruta_base+`api/seguimientos/by_salon_periodo/${salon_uuid}/${periodo}`)
  .then((res) => res.json())
  .then(datos => {
    let caption = `<h2>Periodo ${periodo} :: Seguimientos de ${salon_nombre}</h2>`;
    //console.log(datos);
    
    let result = '';
    let cnt = 0;
    let AsignaturasValidas = [];

    // SOLO PARA VERIFICAR CUALES TIENE DATOS DE SEGUIMIENTO
    for (let cod_estudiante in datos) {
      for (let nom_estudiante in datos[cod_estudiante]) {
        for (let text_abrev in datos[cod_estudiante][nom_estudiante]) {
          for (let abrev in datos[cod_estudiante][nom_estudiante][text_abrev]) {
            const obj = Object.keys(datos[cod_estudiante][nom_estudiante][text_abrev][abrev]);
            if (obj.length>0){
              AsignaturasValidas[abrev] = 1;
            }
          }
        }
      }
    }//END-for
    //console.log(AsignaturasValidas);
    //console.log(AsignaturasValidas.keys());

    // ARMA LA TABLA FINAL
    for (let cod_estudiante in datos) {
      cnt +=1;
      result += `<tr>`;
      for (let nom_estudiante in datos[cod_estudiante]) {
        let columnas = '';
        let anadir = false;
        for (let text_abrev in datos[cod_estudiante][nom_estudiante]) {
          for (let abrev in datos[cod_estudiante][nom_estudiante][text_abrev]) {
            const obj = Object.keys(datos[cod_estudiante][nom_estudiante][text_abrev][abrev]);
            
            let data = datos[cod_estudiante][nom_estudiante][text_abrev][abrev];

            if (AsignaturasValidas.hasOwnProperty(abrev)) {
              if (obj.length==0){
                columnas += `<td></td>`;
              } else {
                fecha = new Date(data.asi_fecha_entrega.replaceAll('-','/') );
                columnas += `
                  <td class="w3-center">
                    <a href="${ruta_base}admin/seguimientos/exportSeguimientosRegistroPdf/${data.uuid}" 
                       class="w3-btn w3-pale-red " 
                       target="_blank"
                       title="DESCARGAR Seguimiento : ${nom_estudiante} - ${abrev} - P${periodo}">
                       ${abrev}
                    </a><br>
                    <span class="w3-small" title="desempeño">${data.asi_desempeno}</span><br>
                    <span class="w3-small" title="fecha de entrega">${fecha.getDate()}-${getNombreMes(fecha)}</span>
                  </td>
                `;
                anadir = true;
              }
            }//END-if

          }
        }

        if (anadir) {
          result += `<td>${cnt}</td><td>${nom_estudiante} [${cod_estudiante}]</td> ${columnas}`;
        }

      }
      result += `</tr>`;
    }


    document.querySelector('#resultados').innerHTML = `
      <table id="myTable"class="w3-table w3-responsive w3-bordered">
        <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">${caption}</caption>
        <tbody id="tbody">${result}</tbody>
      </table>
      `;

  })
  .catch(
    error => document.getElementById('resultados').innerHTML = error
  );


}


function getNombreMes (date)  {
  const MESES = [
    "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul",
    "Ago", "Sep", "Oct", "Nov", "Dic",
  ];
  return MESES[date.getMonth()];  
}
