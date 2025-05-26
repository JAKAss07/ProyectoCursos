document.addEventListener("DOMContentLoaded", function () {
  const inputBusqueda = document.getElementById("buscar");
  const selectCategoria = document.getElementById("categoria");
  const contenedorCursos = document.getElementById("con_cursos");

  function buscarCursosInstructor() {
    const texto = inputBusqueda.value.trim();
    const categoria = selectCategoria.value;

    let url = `../../PHP/Busquedas/BuscarNombreInstructor.php?id_instructor=${idInstructor}`;

    let params = [];

    if (texto.length > 0) {
      params.push("nombre=" + encodeURIComponent(texto));
    }

    if (categoria !== "all" && categoria !== "") {
      params.push("categoria=" + encodeURIComponent(categoria));
    }

    if (params.length > 0) {
      url += "&" + params.join("&");
    }

    fetch(url)
      .then((response) => response.text())
      .then((html) => {
        contenedorCursos.innerHTML = html;
      })
      .catch((err) => {
        contenedorCursos.innerHTML = "<p>Error al buscar cursos.</p>";
        console.error(err);
      });
  }

  inputBusqueda.addEventListener("keyup", buscarCursosInstructor);
  selectCategoria.addEventListener("change", buscarCursosInstructor);

  buscarCursosInstructor(); // carga inicial
});
