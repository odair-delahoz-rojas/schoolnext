document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
});



function traer_data(salon_id) {
  //console.clear();
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  let theme = document.getElementById('theme').innerHTML.trim();
  document.querySelector('#resultados').innerHTML = '<i class="fa fa-refresh w3-xxlarge w3-spin"></i>';

  fetch(ruta_base+'api/notas/notas_salon/'+salon_id)
  .then((res) => res.json())
  .then(datos => {
    let periodo_actual = document.getElementById('periodo_actual').innerHTML.trim();
    let annio_actual = document.getElementById('annio_actual').innerHTML.trim();
    let body_table = '';
    let caption = '';
    let cnt_estudiantes = 1;
    let instit = document.getElementById('instit').innerHTML.trim();

    for (let salon in datos) { 
      [salon_nombre, salon_id, salon_uuid] = salon.split(";");

      caption = `<h2>Salon:${salon_nombre}</h2>`;
      lnk_boletines_salon = 'Boletines:&nbsp;&nbsp;';
      let max_periodo = ((4==periodo_actual) ? 5 : periodo_actual);
      if (instit=='santarosa') {
        max_periodo = 4;
      }

      for (let index=1; index<=max_periodo; index++) {
        lnk_boletines_salon +=  `
        <a href="${ruta_base}admin/notas/exportBoletinSalonPdf/${index}/${salon_uuid}" 
        class="w3-btn w3-round-large w3-black" 
        target="_blank" 
        title="Descarga Boletines de ${salon_nombre} (Per&iacute;odo ${index})">
        <i class="fa-solid fa-file-pdf"></i> ${salon_nombre} (P${index})</a> &nbsp;
        `;
      }
      
      caption = caption +  `${lnk_boletines_salon}<br><br>`
      
      if (instit=='santarosa') 
      {
        lnk_preinformes_salon = 'Preinformes:&nbsp;&nbsp;';
        for (let index=1; index<=max_periodo; index++) 
        {
          lnk_preinformes_salon +=  `
          <a href="${ruta_base}admin/notas/exportPreinformeSalonPdf/${index}/${salon_uuid}" 
          class="w3-btn w3-round-large w3-black" 
          target="_blank" 
          title="Descarga Preinformes de ${salon_nombre} (Per&iacute;odo ${index})">
          <i class="fa-solid fa-file-pdf"></i> ${salon_nombre} (P${index})</a> &nbsp;
          `;
        }
        caption = caption +  `${lnk_preinformes_salon}<br><br>`
      }

      for (let estudiante in datos[salon]) {
        [estudiante_nombre, estudiante_id, estudiante_uuid, is_active, madre, madre_tel, padre, padre_tel,annio_pagado, mes_pagado]= estudiante.split(";");
        body_table += 
        '<tr class="w3-theme-'+theme.toString().substr(0,1)+`5">
          <td colspan=14>
            <h3># ${cnt_estudiantes} ${estudiante_nombre} [${estudiante_id}] :: ${salon_nombre} NOTA-PROM-ESTU BTN-REGISTROS</h3>
            <h6>${ultimoPago(annio_pagado, mes_pagado, annio_actual)}</h6>
            <h6>Padres: ${madre} [${madre_tel}] / ${padre} [${padre_tel}]</h6>
          </td>
        </tr>`;
        
        let cont = 1;
        let arrSumCols = [];
        for (let periodo in datos[salon][estudiante])  // fila de titulos de materia
        {
          if (cont==1) 
          {
            body_table += '<tr class="w3-theme-d3"><td>Per&iacute;odo</td>' + ( (!is_prescolar(salon_nombre)) ? '<td class="w3-center">Prom</td>' : '');            
            for (let asignatura in datos[salon][estudiante][periodo]) 
            {
              [asignatura_nombre, asignatura_abrev]= asignatura.split(";");
              body_table += '<td>' + asignatura_abrev + '</td>';
              arrSumCols[asignatura_abrev] = [];
              arrSumCols[asignatura_abrev]['cnt'] = 0;
              arrSumCols[asignatura_abrev]['val'] = 0;
            }
            body_table += '</tr>';
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
            [asignatura_nombre, asignatura_abrev, calc_prom]= asignatura.split(";");
            nota = datos[salon][estudiante][periodo][asignatura];
            [reg_id, reg_uuid, definitiva, plan_apoyo, nota_final, desempeno, is_asi_validar_ok, is_paf_validar_ok, tiene_logros] = datos[salon][estudiante][periodo][asignatura].split(";");
            
            asi = (is_asi_validar_ok==1) ? '<a href="'+ruta_base+'admin/seguimientos/exportSeguimientosRegistroPdf/'+reg_uuid+'" class="w3-badge w3-white w3-tiny" target="_blank" title="Seguimiento Intermedio">S</a>' : '';
            paf = (is_paf_validar_ok==1) ? '<a href="'+ruta_base+'admin/planes_apoyo/exportPlanesApoyoRegistroPdf/'+reg_uuid+'" class="w3-badge w3-grey w3-tiny" target="_blank" title="Plan de Apoyo">P</a>' : '';
            br = ((asi.length+paf.length)>0) ? '<br>' : '';
            
            let def = '';
            let lleva_pa = '<br>';

            if (definitiva>0 && esNotaBaja(definitiva, instit)) 
            {
              def = `<strong style="color:red">${definitiva}</strong><br>`;
              if (plan_apoyo > 0) 
              {
                lleva_pa = '<strong style="color:'+((esNotaBaja(plan_apoyo, instit))?'red':'black')+'">PA:'+plan_apoyo+'</strong><br>';
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
              fila += `<td class="w3-center w3-padding-tiny w3-small">${def} ${lleva_pa}` + notaFormato(parseInt(nota_final), true, 0, text_adic) + `${br} ${asi} ${paf}</td>`;
            } 
            else 
            {
              const estado = (tiene_logros > 0) ? "<i class=\"fa-solid fa-check w3-large\"></i>" : "<i class=\"fa-solid fa-xmark w3-large w3-red\"></i>";
              fila += `<td class="w3-center w3-padding-tiny w3-small"> ${estado} </td>`;
            }


            if ( (parseInt(nota_final)>0) && (periodo!=5) ) 
            {
              //valor = parseInt(nota_final);
              if (1==calc_prom)
              {
                elementos += 1;
                suma += parseInt(nota_final);
              }
              //elementos += 1;
              //suma += parseInt(nota_final);
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
          
          body_table += fila_nueva +  '</tr>';
        }
        
        // Agregar fila de promedios
        let info_estudiante = '';
        let avg_prom = 0;
        if (!is_prescolar(salon_nombre) && (periodo_actual>1)) 
        {
          let cnt_mat = 0;
          let suma_prom = 0;
          let promedio  = 0;
          fila_proms = '<tr><td>Promedios</td>';
          fila_proms += (!is_prescolar(salon_nombre))?'<td class="w3-center">PROMTOT</td>':'';
  
          for (item in arrSumCols) 
          {
            cnt_mat += 1;
            if (arrSumCols[item]['cnt'] > 0) 
            {
              promedio = arrSumCols[item]['val'] / arrSumCols[item]['cnt'];
              fila_proms += `<td class="w3-center">`+notaFormato(promedio)+`</td>`;
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
          //fila_nueva_proms = fila_proms.replace(/PROMTOT/i, notaFormato(avg_prom));
          fila_nueva_proms = fila_proms.replace(/PROMTOT/i, '');
          body_table += fila_nueva_proms;

          promedio_estudiante = '<span class="w3-tag w3-'+colorRango(avg_prom, instit)+'">'+nombreRango(avg_prom, instit)+'</span>';
        } 
        else 
        {
          promedio_estudiante = '';
        }

        promedio_estudiante = (is_active == 1) ? promedio_estudiante : '<del>'+promedio_estudiante+'</del>';
        body_table = body_table.replace(/NOTA-PROM-ESTU/i, promedio_estudiante);

        let lnk_registro_escolar = `
        <a 
          href="${ruta_base}admin/estudiantes/exportRegistroEscolarByAnnioEstudiante/${annio_actual}/${estudiante_id}" 
          target="_blank" 
          class="w3-button w3-ripple w3-round-large">
          &nbsp;<i class="fa-solid fa-file-pdf"></i> Registro Escolar
        </a>`;

        body_table = body_table.replace(/BTN-REGISTROS/i, lnk_registro_escolar);
        
        cnt_estudiantes += 1;

      }
    }
        
    document.querySelector('#resultados').innerHTML = `
      <table id="myTable"class="w3-table w3-responsive w3-bordered w3-small">
        <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">${caption}</caption>
        <tbody id="tbody">${body_table}</tbody>
      </table>
      `;
    })
    .catch
    (
      error => document.querySelector('#resultados').innerHTML = error
    );

}



function esNotaBaja(valor, instit) 
{
  if ( instit=='windsor' && valor<60 ) return true;
  if ( instit=='santarosa' && valor<30 ) return true;
}

function colorRango(valor, instit) {
  if (valor<1 || valor>100) { return 'DeepPink'; }

  if (instit=='windsor')
  {
    if (valor<60) { return 'red'; }
    if (valor<80) { return 'yellow'; }
    if (valor<95) { return 'blue'; }
    if (valor<=100) { return 'green'; }
  }

  if (instit=='santarosa')
  {
    if (valor<30) { return 'red'; }
    if (valor<38) { return 'orange'; }
    if (valor<45) { return 'light-blue'; }
    if (valor<=50) { return 'green'; }
  }
  
  if (valor<30) { return 'red'; }
  if (valor<38) { return 'orange'; }
  if (valor<45) { return 'light-blue'; }
  if (valor<=50) { return 'green'; }

}

function nombreRango(valor, instit) 
{
  if (valor<0 || valor>100) { return 'err'; }
  if (valor==1) { return ''; }

  if (instit=='windsor')
  {
    if (valor<60) { return 'Bajo'; }
    if (valor<80) { return 'Bas'; }
    if (valor<95) { return 'Alt'; }
    if (valor<=100) { return 'Supe'; }    
  }

  if (instit=='santarosa') 
  {
    if (valor<30) { return 'Bajo'; }
    if (valor<38) { return 'Basi'; }
    if (valor<45) { return 'Alto'; }
    if (valor<=50) { return 'Supe'; }
  }

  if (valor<30) { return 'Bajo'; }
  if (valor<38) { return 'Basi'; }
  if (valor<45) { return 'Alto'; }
  if (valor<=50) { return 'Supe'; }
}


function notaFormato(valor, brake = true, fixed =2, text2='') 
{
  let instit = document.getElementById('instit').innerHTML.trim();
  fixed =  (valor % 1 !== 0) ? fixed : 0;  
  let valor_fixed = valor.toFixed(fixed);
  let style_color = 'class="w3-tag w3-'+colorRango(valor_fixed, instit)+'"';
  let nombre_rango = nombreRango(valor_fixed, instit);
  let nombre_rango_title = `title="${nombre_rango} ${text2}"`;
  let br = (brake) ? '<br>' : '';
  return `<span ${style_color} ${nombre_rango_title}>${valor_fixed}</span>${br}`;
}


function is_prescolar(nombre_salon) 
{
  var regex = /(PV-A|PK-A|KD-A|TN-A)/;
  return regex.test(nombre_salon);
}


function ultimoPago(annio_pagado, mes_pagado, annio_actual)
{  
  if (mes_pagado<1 || mes_pagado>12) 
  {
    return 'err-mes';
  }
  
  const Meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  let nombre_mes = Meses[mes_pagado-1];
  result = `Último Pago: ${nombre_mes} de ${annio_pagado}`;

  if (annio_actual > annio_pagado)
  {
    result = `<del>${result}</del>`;
  }

  return result;
}