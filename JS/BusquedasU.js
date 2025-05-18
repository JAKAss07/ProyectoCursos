document.addEventListener("DOMContentLoaded", function () {
  const inputBusqueda = document.getElementById("buscar"); // solo por id
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

  cargarTodosLosCursos();

  inputBusqueda.addEventListener("keyup", function () {
    const texto = inputBusqueda.value.trim();

    if (texto.length === 0) {
      cargarTodosLosCursos();
    } else {
      fetch(
        `PHP/Busquedas/BuscarNombre.php?nombre=${encodeURIComponent(texto)}`
      )
        .then((response) => response.text())
        .then((html) => {
          contenedorCursos.innerHTML = html;
        })
        .catch((err) => {
          contenedorCursos.innerHTML = "<p>Error al buscar cursos.</p>";
          console.error(err);
        });
    }
  });
});
