$(document).ready(function() {
  $('a[data-url][data-location]').each(function() {
    var url = $(this).data('url');
    var location = $(this).data('location');



if (url && location) {
  $(location).load(url, function(response, status, xhr) {
    if (status === "error") {
      console.error("Error cargando " + url + ": " + xhr.status + " " + xhr.statusText);
    } else {
      console.log("Cargado correctamente: " + url + " en " + location);
    }
  });
}
  });
});
