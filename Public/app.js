const URL = 'http://biblioteca';
//Variables para poder manipular la paginacion
const registrosPorPagina = 10;
let paginaActual = 1;

//Esperamos que la pagina se termine de cargar
document.addEventListener('DOMContentLoaded', function () {
        //Obtenemos los generos y los cargamos.
        getGeneros('genero');
        getGeneros('egenero');
        
        //Validamos los inputs al momento de guardar un libro.
        validarFormulario('formLibros');

// Inicializar la tabla y la paginación al cargar la página
cargarLibros();
});

/**
*La función de JavaScript proporcionada validarFormulario valida un formulario comprobando si campos específicos están completados antes de permitir el envío del formulario.
*
* @param idForm - El parámetro idForm en la función validarFormulario es el id del formulario que deseas validar.
* Esta función establece un "event listener" en el evento de envío *del formulario para prevenir el comportamiento 
* predeterminado de envío del formulario y luego valida campos específicos dentro del formulario antes de permitir que se envíe.
* 
* @returns un mensaje alertando al usuario para completar los campos requeridos si alguno de ellos está vacío o no seleccionado
* Si todos los campos están completados, se enviará el formulario.
*/
function validarFormulario(idForm){
        //Obtenemos el formulario sobre el cual estamos trabajando.
        const form = document.getElementById(idForm);

        //Agregamos un evento el cual se ejecuta, al dar click en el boton 'Enviar'
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío automático del formulario

            // Definimos los campos que deben  ser enviados de manera obligatoria
            const fields = {
                'titulo': 'Titulo',
                'fecha': 'Fecha de publicacion',
                'genero': 'Genero',
                'autor': 'Autor',
                'isbn': 'ISBN',
                'descripcion': 'Descripcion'
            };

            // Verificar cada campo del formulario
            for (const field in fields) {
                console.log(field);
                const value = document.getElementById(field).value.trim();

                // Verificar si el campo está vacío
                if (value === '' || (field === 'genero' && value === 'Selecionar')) {
                    alert(`Por favor, complete el campo ${fields[field]}.`);
                    return; // Detener el envío del formulario
                }
            }

            // Envía el formulario si pasa todas las validaciones
            this.submit();
        });
}


/**
*
* La función "editar" obtiene los datos de un libro por su ID, formatea la fecha y rellena un formulario con los detalles del libro.
* @param id - La función editar se utiliza para obtener y rellenar un formulario con los detalles de un libro
* basado en su id. La función envía una solicitud GET a http://biblioteca/libros/buscar/{id} para
* recuperar la información del libro.
*/
function editar(id) {
        // Realizar una solicitud GET a /libros/buscar/{id}
        fetch(`${URL}/libros/buscar/${id}`)
            .then(response => {
                //Si la respuesta no es ok lanzamos una exepcion.
                if (!response.ok) {
                    throw new Error('No se pudo obtener los datos del libro ');
                }
                return response.json();
            })
            .then(libro => {
                
                var fecha = new Date(libro.fecha); // Convertir la fecha a un objeto Date

                // Formatear la fecha en formato "YYYY-MM-DD" para asignarla al campo de fecha
                var formattedFecha = fecha.toISOString().split('T')[0];

                // Asignar los valores del libro al formulario
                document.getElementById('eid').value = libro.tiid;
                document.getElementById('etitulo').value = libro.titulo;
                document.getElementById('efecha').value = formattedFecha;
                document.getElementById('egenero').value = libro.genero;
                document.getElementById('eautor').value = libro.Anombre;
                document.getElementById('eisbn').value = libro.ISBN;
                document.getElementById('edescripcion').value = libro.Comentarios;

            })
            .catch(error => {
                console.error('Error al obtener los datos del libro:', error );
            });
    }
function getGeneros(idInput) {

    // Realizar una solicitud GET a /libros/generos
    fetch(`${URL}/libros/generos`)
    .then(response => {
        if (!response.ok) {
            throw new Error('No se pudo obtener los datos de los géneros');
        }
        return response.json(); // Asegurarse de que la respuesta se convierta en JSON
    })
    .then(data => {

        // Obtener el elemento select de los géneros
        const selectGenero = document.getElementById(idInput);


        // Iterar sobre los datos recibidos y agregar opciones al select
        data.forEach(genero => {
            // Crear una opción para cada género
            const option = new Option(genero.Gnombre, genero.id_genero);

            selectGenero.appendChild(option);
        });

        // Establecer la opción por defecto "Seleccionar" como seleccionada - No logre hacer que funcion :$
        const defaultOption = new Option("Seleccionar", "");
        selectGenero.insertBefore(defaultOption, selectGenero.firstChild);
        selectGenero.selectedIndex = 0;
    })
    .catch(error => {
        console.error('Error al obtener los datos de los géneros:', error);
    });


}

/**
* La función eliminar confirma la eliminación de un registro, envía una solicitud al servidor para eliminarlo,
* y maneja los mensajes de éxito o error en consecuencia.
* @param id - El parámetro id en la función eliminar es el identificador único del registro
* que deseas eliminar. Este identificador se utiliza para especificar qué registro debe ser eliminado de la
* base de datos cuando se envía la solicitud de eliminación al servidor.
*/
function eliminar(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
        // Realizar la solicitud al servidor
        fetch(`${URL}/libros/eliminar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => {
            if (response.ok) {
                // La solicitud se completó exitosamente (status 200)
                alert("Registro eliminado correctamente");
                location.reload();
            } else {
                // La solicitud falló
                alert("Hubo un problema al eliminar el registro");
            }
        })
        .catch(error => {
            // Manejo de errores de red o del servidor
            console.error('Error al eliminar el registro:', error);
            alert("Hubo un error al procesar la solicitud");
        });
    }
}




/**
* La función mostrarRegistros muestra un subconjunto de datos en una página web en formato de tabla con
* opciones para editar o eliminar cada registro.
* @param datos - El parámetro datos representa un array
* de objetos, donde cada objeto contiene información sobre un libro.
* @param pagina - El parámetro representa el número de página
* actual que deseas mostrar en la tabla. Este parámetro se utiliza para calcular qué subconjunto
* de datos (registros) debe mostrarse en la página especificada. Al especificar el número de página, la función
* determina el rango
*/
function mostrarRegistros(datos, pagina) {
    const inicio = (pagina - 1) * registrosPorPagina;
    const fin = inicio + registrosPorPagina;
    const datosPagina = datos.slice(inicio, fin);

    const tabla = document.getElementById('tablaLibros');
    tabla.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos datos

    // Crear el encabezado de la tabla (thead)
    const encabezado = document.createElement('thead');
    encabezado.innerHTML = `<tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Autor</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Genero</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Acciones</th>
                            </tr>`;
    tabla.appendChild(encabezado);

    // Iterar sobre los datos de la página actual y agregarlos a la tabla
    datosPagina.forEach(libro => {
        const cuerpo = document.createElement('tbody');
        cuerpo.innerHTML = `<tr><td>${libro.tiid}</td>
                          <td>${libro.titulo}</td>
                          <td>${libro.Anombre}</td>
                          <td>${libro.ISBN}</td>
                          <td>${libro.Gnombre}</td>
                          <td>${libro.Comentarios}</td>
                          <td>${libro.fecha}</td>
                          <td><img src='${libro.imagen}' class="img-thumbnail img-fluid" alt="..."></td>
                          <td class="d-flex">
                              <button type="button" class="btn btn-danger m-1" onclick="eliminar(${libro.tiid})">Eliminar</button>
                              <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editarLibro" onclick="editar(${libro.tiid})">Editar</button>
                          </td></tr>`;
        tabla.appendChild(cuerpo);
    });
}

/**
* La función genera botones de paginación basados en el número total de páginas, con una visualización dinámica
* de números de página o puntos suspensivos para la navegación.
* @param totalPaginas - La función generarBotonesPaginacion está diseñada para generar botones de paginación
* basados en el número total de páginas (totalPaginas). La función crea dinámicamente
* botones de paginación para navegar a través de diferentes páginas.
*/
function generarBotonesPaginacion(totalPaginas) {
    const paginacion = document.getElementById("paginacion");
    paginacion.innerHTML = "";

    const paginaAnterior = document.createElement("li");
    paginaAnterior.className = "page-item";
    paginaAnterior.innerHTML = '<a class="page-link" id="paginaAnterior">Atras</a>';
    paginacion.appendChild(paginaAnterior);

    if (totalPaginas <= 9) {
        for (let i = 1; i <= totalPaginas; i++) {
            const botonPagina = crearBotonPagina(i);
            paginacion.appendChild(botonPagina);
        }
    } else {
        let inicio, fin;
        if (paginaActual <= 5) {
            inicio = 1;
            fin = 9;
        } else if (paginaActual >= totalPaginas - 4) {
            inicio = totalPaginas - 8;
            fin = totalPaginas;
        } else {
            inicio = paginaActual - 4;
            fin = paginaActual + 4;
        }

        if (inicio > 1) {
            const botonPuntosAnteriores = crearBotonPagina("...");
            paginacion.appendChild(botonPuntosAnteriores);
        }

        for (let i = inicio; i <= fin; i++) {
            const botonPagina = crearBotonPagina(i);
            paginacion.appendChild(botonPagina);
        }

        if (fin < totalPaginas) {
            const botonPuntosSiguientes = crearBotonPagina("...");
            paginacion.appendChild(botonPuntosSiguientes);
        }
    }

    const paginaSiguiente = document.createElement("li");
    paginaSiguiente.className = "page-item";
    paginaSiguiente.innerHTML = '<a class="page-link" id="paginaSiguiente">Siguiente</a>';
    paginacion.appendChild(paginaSiguiente);
}



/**
* La función crea un elemento de botón de paginación con un número especificado y un evento onclick para
* cambiar la página.
* @param numero - El parámetro numero en la función crearBotonPagina representa el número de página
* que se mostrará en el botón creado por la función. Este número de página se utilizará para
* navegar a una página específica cuando se haga clic en el botón.
* @returns Un elemento de ítem de lista HTML creado dinámicamente que representa un botón de página con un
* número de página específico y un controlador de eventos onclick para llamar a la función cambiarPagina
* con el número de página dado como argumento.
*/
function crearBotonPagina(numero) {
    const botonPagina = document.createElement('li');
    botonPagina.className = 'page-item';
    botonPagina.innerHTML = `<a class="page-link" href="#" onclick="cambiarPagina(${numero})">${numero}</a>`;
    return botonPagina;
}

/**
 * Funcion para cambian de pagina en la tabla.
 * @param {numero} numero numero al cual vamos a cambiar de pagina
 */
function cambiarPagina(numero) {
    paginaActual = numero;
    cargarLibros();
}
// Función para cargar los libros desde el backend y servirlos en una tabla.
function cargarLibros() {
    fetch('/inicio/obtenerdatos')
        .then(response => response.json())
        .then(data => {
            // Actualizar la tabla y la paginación con los datos recibidos
            mostrarRegistros(data, paginaActual);
            generarBotonesPaginacion(Math.ceil(data.length / registrosPorPagina));
            console.log(data);
        })
        .catch(error => {
            console.error('Error al cargar los libros:', error);
        });
}