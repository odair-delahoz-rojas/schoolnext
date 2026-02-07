
var countDownDate = new Date("Apr 28, 2022 00:00:00").getTime();
//var countDownDate = new Date(document.getElementById("fecha_hito")).getTime();

var x = setInterval( function() {
  var now = new Date().getTime();
  var distance = countDownDate-now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById("demo").innerHTML = 'Open Day: ' + days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EL EVENTO EXPIRÓ";
  }
}, 1000); // Update the count down every 1 second