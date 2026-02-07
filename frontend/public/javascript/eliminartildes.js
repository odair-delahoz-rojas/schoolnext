function eliminarTildes() {
  const textoConTildes = document.getElementById("texto").value;
  const textoSinTildes = textoConTildes.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  document.getElementById("texto").value = textoSinTildes;
}