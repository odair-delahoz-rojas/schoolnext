
function myFunctionFilter() {
  var input, filter, arrayDeFilter, table, tr, td, i, td_i, td_ii, hit1, hit2;
 input = document.getElementById("inputSearch2");
 filter = input.value.toUpperCase().trim();
 arrayDeFilter = filter.split(" ");
table = document.getElementById("myTable2");
tr = table.getElementsByClassName("item");
for (tri = 0; tri < tr.length; tri++) {
  td = tr[tri].getElementsByClassName("searchTdata");
    hit1 = 0;
    for (td_i = 0; td_i < td.length; td_i++) {
      hit2 = 0;
      for (td_ii = 0; td_ii < arrayDeFilter.length; td_ii++) {
        if (td[td_i].innerText.toUpperCase().indexOf(arrayDeFilter[td_ii].toUpperCase()) > -1) {
          hit2 += 1;
        }
      }
      if (hit2==arrayDeFilter.length) { 
        hit1 += 1;
      }
    }
    
    if (hit1>=1) {
      tr[tri].style.display = "";
    } else {
      tr[tri].style.display = "none";
    }
  }
}

document.getElementById("inputSearch2").addEventListener("keyup", myFunctionFilter);