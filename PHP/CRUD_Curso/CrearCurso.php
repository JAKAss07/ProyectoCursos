<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso</title>
    <link rel="stylesheet" href="../../CSS/normalize.css">
    <link rel="stylesheet" href="../../CSS/CrearCurso.css">
</head>

<script>
    function agregarTema() {
        const container = document.getElementById("temasContainer");

        const div = document.createElement("div");
        div.classList.add("tema-item");
        div.innerHTML = `
            <label>Título del tema:</label>
            <input type="text" name="tituloTema[]" required>
            <label>Link del video:</label>
            <input type="url" name="linkVideo[]" required>
            <button type="button" onclick="this.parentElement.remove()" id="boton_2">Eliminar</button>
            <hr>
        `;
        container.appendChild(div);
    }
</script>

<body>

    <div id="cont_c">
        <section id="panelD">
            <div id="crearCurso">
                <form id="formulario">
                    <div id="conPaneles">
                        <div id="formIZ">
                            <h2>Crear Curso</h2>
                            <label for="nombreCurso">Nombre del curso:</label>
                            <input type="text" id="nombreC" name="NombreC" required>

                            <div id="contTem">
                                <label for="tema">Tema:</label>
                                <br>
                                <select id="tema" name="tema" required>
                                    <option value="">Selecciona</option>
                                    <option value="all">Todas las Categorías</option>
                                    <option value="Matematicas">Matemáticas</option>
                                    <option value="Manualidades">Manualidades</option>
                                    <option value="Tecnologia">Tecnología</option>
                                    <option value="3D">3D</option>
                                </select>
                            </div>
                            
                            <label for="precioC">Precio del Curso:</label>
                            <input type="text" id="precioC" name="precioC" required>

                            <label for="descripcion">Descripción:</label>
                            <input type="text" id="descripcion" name="descripcion" required>

                            <label for="quienCurso">Para quien es el curso</label>
                            <input type="text" id="quienCurso" name="quienCurso" required>

                            <label for="requisitoC">Requisitos para el curso:</label>
                            <input type="text" id="requisitoC" name="requisitoC" required>
                        </div>

                        <div id="formDR">
                            <h3>Temas del Curso</h3>
                            <div id="temasContainer">
                                <div class="tema-item">
                                    <label>Título del tema:</label>
                                    <input type="text" name="tituloTema[]" required>
                                    <label>Link del video:</label>
                                    <input type="url" name="linkVideo[]" required>
                                    <button type="button" onclick="this.parentElement.remove()" id="boton_2">Eliminar</button>
                                    <hr>
                                </div>
                            </div>
                            <button type="button" onclick="agregarTema()" id="boton_1">Agregar Tema</button>
                        </div>
                    </div>


                    <button id="boton" type="submit">Crear Curso</button>
                </form>
            </div>

            <div id="crearExamen">
                <!-- No se hara -->
            </div>
        </section>

        <section id="opciones_c">
            <div id="img_logo ">
                <div id="logo_i"><img src="../../Img/Logo.png" id="img_logo"></div>
            </div>
            <a id="boton" href="">Crear Curso</a>
            <a id="boton" href="">Crear Examen</a>
            <a id="boton" href="CursosCRUD.php">Regresar</a>
        </section>
    </div>
</body>

</html>