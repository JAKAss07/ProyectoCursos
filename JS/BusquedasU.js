document.addEventListener("DOMContentLoaded", function () {
  const inputBusqueda = document.getElementById("buscar");
  const selectCategoria = document.getElementById("categoria");
  const contenedorCursos = document.getElementById("con_cursos");

  function cargarTodosLosCursos() {
    fetch("PHP/Busquedas/TodosLosCursos.php")
      .then((response) => response.text())
      .then((html) => {
        contenedorCursos.innerHTML = html;
      })
      .catch((err) => {
        contenedorCursos.innerHTML = "<p>Error al cargar cursos.</p>";
        console.error(err);
      });
  }

  function buscarCursos() {
    const texto = inputBusqueda.value.trim();
    const categoria = selectCategoria.value;

    // Si no hay texto y categoría es "all", cargo todo
    if (texto.length === 0 && (categoria === "all" || categoria === "")) {
      cargarTodosLosCursos();
      return;
    }
    let url = "PHP/Busquedas/BuscarNombre.php?";
    let params = [];

    if (texto.length > 0) {
      params.push("nombre=" + encodeURIComponent(texto));
    }

    if (categoria !== "all" && categoria !== "") {
      params.push("categoria=" + encodeURIComponent(categoria));
    }

    url += params.join("&");

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

  // Eventos
  inputBusqueda.addEventListener("keyup", buscarCursos);
  selectCategoria.addEventListener("change", buscarCursos);

  cargarTodosLosCursos();
});
