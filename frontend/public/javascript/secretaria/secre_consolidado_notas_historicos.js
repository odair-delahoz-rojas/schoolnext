  document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('annio-0').click();
  });


  /**
   * CARGAR LOS GRADOS SEGUN EL AÑO SELECCIONADO
   * @param {*} annio 
   */
  function traer_grados(annio) 
  {
    document.querySelector('#grado').innerHTML = '<i class="fa fa-refresh w3-xxlarge w3-spin"></i>';
    document.querySelector('#botones').innerHTML = '';
    document.querySelector('#resultados').innerHTML = '';

    let ruta_base = document.getElementById('public_path').innerHTML.trim();
    let url = ruta_base+'api/notas/grados_annio/'+annio;
    fetch(url)
    .then((res) => res.json())
    .then(datos => 
      {
        let html = '<div class="w3-bar">';
        for (let key in datos) 
        { 
          html += `<div class=\"w3-bar-item\">
                      <button id="grado-${key}" onclick="traer_data(${datos[key].grado_id}, ${datos[key].annio}, ${datos[key].max_periodos})" class="w3-bar-item">
                        ${datos[key].grado_abrev}
                      </button>
                    </div>`;
        }
        html += '</div>';
        document.querySelector('#grado').innerHTML = 'GRADOS DEL AÑO ' + annio;
        document.querySelector('#botones').innerHTML = html;
        document.getElementById('grado-0').click();
      })
      .catch(
          error => document.querySelector('#botones').innerHTML = error
      );
  }

  /**
   * TARER LAS NOTAS DE LOS ESTUDIANTES DEL GRADO Y AÑO ESTABLECIDOS
   * @param {*} grado_id 
   * @param {*} annio 
   * @param {*} max_periodo 
   */
  function traer_data(grado_id, annio, max_periodo) {
    console.clear();
    let ruta_base = document.getElementById('public_path').innerHTML.trim();
    let url = ruta_base+'api/notas/notas_grado/'+grado_id+'/'+annio;
    let theme = document.getElementById('theme').innerHTML.trim();
    let resultados =  document.querySelector('#resultados');

    resultados.innerHTML = '<i class="fa fa-refresh w3-xxlarge w3-spin"></i>';
    fetch(url)
    .then((res) => res.json())
    .then(datos => {
      let body_table = '';
      let caption = '';
      let cnt_estudiantes = 1;

      for (let grado in datos) { 
        [grado_nombre, grado_id, grado_abrev, salon_nombre, salon_id] = grado.split(";");
        lnk_boletines_salon = 'Boletines:&nbsp;&nbsp;';

        caption = `<h2>GRADO: ${grado_nombre}</h2>`;
        for (let estudiante in datos[grado]) {
          [estudiante_nombre, estudiante_id, estudiante_uuid]= estudiante.split(";");

          let info_estudiante = (`# ${cnt_estudiantes} ${estudiante_nombre} [${estudiante_id}] :: ${annio} - ${grado_abrev}`).toUpperCase()+'°';
          body_table += '<tr class="w3-theme-'+theme.toString().substr(0,1)+`5"><td colspan=12><h3>${info_estudiante}</h3></td></tr>`;
          
          let cont = 1;
          let arrSumCols = [];
          for (let periodo in datos[grado][estudiante]) { // fila de titulos de materia
            if (cont==1) {
              body_table += '<tr class="w3-theme-d3"><td>Per&iacute;odo</td>'+ ( (!is_prescolar(grado_id)) ? '<td class="w3-center">Prom</td>' : '');            
              for (let asignatura in datos[grado][estudiante][periodo]) {
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
              <a href="${ruta_base}admin/notas/exportBoletinEstudianteHistPdf/${annio}/${salon_id}/${periodo}/${estudiante_uuid}" 
              class="w3-btn w3-round-large w3-black w3-tiny" 
              target="_blank"
              title="Descarga Boletin de ${estudiante_nombre} (Per&iacute;odo ${periodo})">
              Boletin P${periodo}</a>
            `;
            
            //let fila = `<tr class="w3-theme-l3"><td>${lnk_boletin_estud_periodo}</td>` + ( (!is_prescolar(grado_id)) ? `<td class="w3-center">PROMMAT</td>` : ''); 
            let fila = `
            <tr class="w3-theme-l3">
              <td>${lnk_boletin_estud_periodo}</td>` 
              + ( (!is_prescolar(grado_id)) ? `<td class="w3-center">PROMMAT</td>` : ''); 
            let suma = 0;
            let elementos = 0;
            
            for (let asignatura in datos[grado][estudiante][periodo]) {
              [asignatura_nombre, asignatura_abrev] = asignatura.split(";");

              [reg_id, definitiva, plan_apoyo, nota_final] = datos[grado][estudiante][periodo][asignatura].split(";");
              fila += '<td class="w3-center w3-padding-small w3-small">' + notaFormato(parseInt(nota_final), asignatura_abrev, true, 0) + '</td>';
              
              if (parseInt(nota_final)>0) {
                elementos += 1;
                suma += parseInt(nota_final);
                arrSumCols[asignatura_abrev]['cnt'] += 1;
                arrSumCols[asignatura_abrev]['val'] += parseInt(nota_final);
              }
            }          
            
            let avg = 0;
            if (elementos>0) {
              avg = suma / elementos;  
            }
            fila_nueva = fila.replace(/PROMMAT/i, notaFormato(avg, asignatura_abrev));
            body_table += fila_nueva+  '</tr>';
          }

          cnt_estudiantes += 1;
        }
      }
      
      
      resultados.innerHTML = `
        <table id="myTable"class="w3-table w3-responsive w3-bordered w3-small">
          <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">${caption}</caption>
          <tbody id="tbody">${body_table}</tbody>
        </table>
        `;
      })
      .catch(
          error => resultados.innerHTML = error
      );


  }


  function colorRango(valor, instit) 
  {
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


  function notaFormato(valor, materia='', brake = true, fixed =2) {
    let instit = document.getElementById('instit').innerHTML.trim();
    fixed =  (valor % 1 !== 0) ? fixed : 0;  
    let valor_fixed = valor.toFixed(fixed);
    let style_color = 'class="w3-tag w3-'+colorRango(valor_fixed,instit)+'"';
    let nombre_rango = nombreRango(valor_fixed,instit);
    let nombre_rango_title = `title="${materia} ${valor} [${nombre_rango}]"`;
    let br = (brake) ? '<br>' : '';
    return `<span ${style_color} ${nombre_rango_title}>${valor_fixed}</span>${br}${nombre_rango}`;
  }

  function is_prescolar(grado_id) {
    var regex = /(12|13|14|15)/;
    return regex.test(grado_id);
  }
