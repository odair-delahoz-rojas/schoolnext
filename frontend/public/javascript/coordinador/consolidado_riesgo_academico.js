document.addEventListener('DOMContentLoaded', function () {
  document.querySelector('#spinner').style.display = "none";
  document.getElementById('btn-0').click();
  
});



function traer_data(salon_id) {
  //console.clear();
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  let theme = document.getElementById('theme').innerHTML.trim();
  document.querySelector('#resultados').innerHTML = '';
  document.querySelector('#spinner').style.display = "block";

  fetch(ruta_base+'api/notas/notas_salon/'+salon_id)
  .then((res) => res.json())
  .then(datos => {
    let periodo_actual = document.getElementById('periodo_actual').innerHTML.trim();
    let body_table = '';
    let caption = '';
    let cnt_estudiantes = 1;

    for (let salon in datos) { 
      [salon_nombre, salon_id, salon_uuid] = salon.split(";");
      lnk_boletines_salon = 'Boletines:&nbsp;&nbsp;';
      let max_periodo = ((4==periodo_actual) ? 5 : periodo_actual);

      caption = `<h2>Salon:${salon_nombre}</h2>`;
      for (let estudiante in datos[salon]) {
        [estudiante_nombre, estudiante_id, estudiante_uuid, is_active, madre, madre_tel, padre, padre_tel,annio_pagado, mes_pagado]= estudiante.split(";");
        let body_notas_estudiante = 
        '<tr class="w3-theme-'+theme.toString().substr(0,1)+`5">
          <td colspan=14>
            <h3># ${cnt_estudiantes} ${estudiante_nombre} [${estudiante_id}] :: ${salon_nombre} NOTA-PROM-ESTU</h3>
          </td>
        </tr>`;
        
        let cont = 1;
        let arrSumCols = [];
        for (let periodo in datos[salon][estudiante])  // fila de titulos de materia
        {
          if (cont==1) 
          {
            body_notas_estudiante += '<tr class="w3-theme-d3"><td>Per&iacute;odo</td>' + ( (!is_prescolar(salon_nombre)) ? '<td class="w3-center">Prom</td>' : '');            
            for (let asignatura in datos[salon][estudiante][periodo]) 
            {
              [asignatura_nombre, asignatura_abrev]= asignatura.split(";");
              body_notas_estudiante += '<td>' + asignatura_abrev + '</td>';
              arrSumCols[asignatura_abrev] = [];
              arrSumCols[asignatura_abrev]['cnt'] = 0;
              arrSumCols[asignatura_abrev]['val'] = 0;
            }
            body_notas_estudiante += '</tr>';
            cont += 1;
          }
          lnk_boletin_estud_periodo =  `
            <a href="${ruta_base}admin/notas/exportBoletinEstudiantePdf/${periodo}/${estudiante_uuid}" 
            class="w3-btn w3-round-large w3-black w3-tiny" 
            target="_blank"
            title="Descarga Boletin de ${estudiante_nombre} (Per&iacute;odo ${periodo})">
            <i class="fa-solid fa-file-pdf"></i>&nbsp;P${periodo}</a>
          `;
          
          let fila = `<tr class="w3-theme-l3"><td>${lnk_boletin_estud_periodo}</td>` + ( (!is_prescolar(salon_nombre)) ? `<td class="w3-center"><br>PROMMAT</td>` : ''); 
          let suma = 0;
          let elementos = 0;
          
          for (let asignatura in datos[salon][estudiante][periodo]) 
          {
            [asignatura_nombre, asignatura_abrev]= asignatura.split(";");
            nota = datos[salon][estudiante][periodo][asignatura];
            [reg_id, reg_uuid, definitiva, plan_apoyo, nota_final, desempeno, is_asi_validar_ok, is_paf_validar_ok, tiene_logros] = datos[salon][estudiante][periodo][asignatura].split(";");
            
                       
            let def = '';
            let lleva_pa = '<br>';

            if (definitiva>0 && definitiva<60) 
            {
              def = `<strong style="color:red">${definitiva}</strong><br>`;
              if (plan_apoyo > 0) 
              {
                lleva_pa = '<strong style="color:'+((plan_apoyo<60)?'red':'black')+'">PA:'+plan_apoyo+'</strong><br>';
              } 
              else 
              {
                lleva_pa = (plan_apoyo > 0) ? '<strong style="color:red">'+definitiva+'</strong><br><strong style="color:red">PA:'+plan_apoyo+'</strong><br>' : 'PA:?<br>';
              }
            } 
            else 
            {
              lleva_pa = '<br>';
            }
            const text_adic = `${asignatura_abrev} P${periodo}`;

            if (!is_prescolar(salon_nombre)) {
              fila += `<td class="w3-center w3-padding-tiny w3-small">${def} ${lleva_pa}` + notaFormato(parseInt(nota_final), true, 0, text_adic) + `</td>`;
            } 
            else 
            {
              const estado = (tiene_logros > 0) ? "<i class=\"fa-solid fa-check w3-large\"></i>" : "<i class=\"fa-solid fa-xmark w3-large w3-red\"></i>";
              fila += `<td class="w3-center w3-padding-tiny w3-small"> ${estado} </td>`;
            }

            
            if ( (parseInt(nota_final)>0) && (periodo!=5) ) 
            {
              elementos += 1;
              suma += parseInt(nota_final);
              arrSumCols[asignatura_abrev]['cnt'] += 1;
              arrSumCols[asignatura_abrev]['val'] += parseInt(nota_final);
            }
          }
          
          let avg = 0;
          if (elementos>0) 
          {
            avg = suma / elementos;  
          }
          
          if (!is_prescolar(salon_nombre)) 
          {
            fila_nueva = fila.replace(/PROMMAT/i, notaFormato(avg));
          } 
          else 
          {
            fila_nueva = fila;
          }
          
          body_notas_estudiante += fila_nueva +  '</tr>';
        }
        
        // Agregar fila de promedios
        let info_estudiante = '';
        let avg_prom = 0;
        let contador_materias_perdidas = 0;

        if (!is_prescolar(salon_nombre) && (periodo_actual>1)) 
        {
          let cnt_mat = 0;
          let suma_prom = 0;
          let promedio  = 0;
          fila_proms = `<tr><td>Promedios:</td>`;
          fila_proms += (!is_prescolar(salon_nombre))?'<td class="w3-center">PROMTOT</td>':'';

          for (item in arrSumCols) 
          {
            cnt_mat += 1;
            if (arrSumCols[item]['cnt'] > 0) 
            {
              promedio = arrSumCols[item]['val'] / arrSumCols[item]['cnt'];
              contador_materias_perdidas += ((promedio<60) ? 1 : 0);
              fila_proms += `<td class="w3-center">`+notaFormato(promedio) + ((promedio<60) ? ' perdida' : '') + ` </td>`;
            } 
            else
            {
              promedio = 0;
              fila_proms += `<td class="w3-center">${promedio}</td>`;
            }
            suma_prom += promedio;
          }
          fila_proms += '</tr>';
  
          avg_prom = (suma_prom/cnt_mat);
          fila_nueva_proms = fila_proms.replace(/PROMTOT/i, notaFormato(avg_prom));
          body_notas_estudiante += fila_nueva_proms;

          riesgo = fnRiesgoPerdida(contador_materias_perdidas);

          promedio_estudiante = '<span class="w3-tag w3-'+colorRango(avg_prom)+'">'+nombreRango(avg_prom) +'</span> ' + riesgo;
        } 
        else 
        {
          promedio_estudiante = '';
        }

        promedio_estudiante = (is_active == 1) ? promedio_estudiante : '<del>'+promedio_estudiante+'</del>';
        body_notas_estudiante = body_notas_estudiante.replace(/NOTA-PROM-ESTU/i, promedio_estudiante);

        if (contador_materias_perdidas>0) {
          body_table += body_notas_estudiante;          
          cnt_estudiantes += 1;
        }

      }
    }
    

    if (body_table.length==0) {
      document.querySelector('#resultados').innerHTML = `<h2>No hay registros para mostrar: ${caption}</h2>`;
    } 
    else
    {
      document.querySelector('#resultados').innerHTML = `
      <table id="myTable"class="w3-table w3-responsive w3-bordered w3-small">
        <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">${caption}</caption>
        <tbody id="tbody">${body_table}</tbody>
      </table>
      `;
    }    

      
    document.querySelector('#spinner').style.display = "none";

    })
    .catch
    (
      error => document.querySelector('#resultados').innerHTML = error
    );


}


function fnRiesgoPerdida(valor) 
{
  switch (valor) {
    case 1:
      return `Riesgo Bajo [${valor}]`;
      break;
    case 2:
      return `Riesgo Moderado [${valor}]`;
      break;
      case 2:
        return `Riesgo Alto [${valor}]`;
        break;
    default:
      return `Riesgo Muy Alto [${valor}]`;
      break;
  }
}

function colorRango(valor) 
{
  if (valor<0 || valor>100) { return 'DeepPink'; }
  if (valor<1) { return 'black'; }  
  if (valor<60) { return 'red'; }
  if (valor<80) { return 'yellow'; }
  if (valor<95) { return 'blue'; }
  if (valor<=100) { return 'green'; }
}

function nombreRango(valor) 
{
  if (valor<0 || valor>100) { return 'err'; } 
  if (valor<1) { return ''; }  
  if (valor<60) { return 'Bajo'; }
  if (valor<80) { return 'Básico'; }
  if (valor<95) { return 'Alto'; }
  if (valor<=100) { return 'Superior'; }
}

function notaFormato(valor, brake = true, fixed =2, text2='') 
{
  fixed =  (valor % 1 !== 0) ? fixed : 0;  
  let valor_fixed = valor.toFixed(fixed);
  let style_color = 'class="w3-tag w3-'+colorRango(valor_fixed)+'"';
  let nombre_rango = nombreRango(valor_fixed);
  let nombre_rango_title = `title="${nombre_rango} ${text2}"`;
  let br = (brake) ? '<br>' : '';
  return `<span ${style_color} ${nombre_rango_title}>${valor_fixed}</span>${br}`;
}

function is_prescolar(nombre_salon) 
{
  var regex = /(PV-A|PK-A|KD-A|TN-A)/;
  return regex.test(nombre_salon);
}
