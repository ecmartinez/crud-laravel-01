<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <button
                    type="button"
                    class="btn btn-outline-primary float-right mb-3"
                    @click.prevent="nuevoDato()"
                >
                    Nuevo
                </button>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Posicion</th>
                            <th scope="col">Salario</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dato in datos">
                            <td>{{ dato.id }}</td>
                            <td>{{ dato.nombre }}</td>
                            <td>{{ dato.posicion }}</td>
                            <td>{{ dato.salario }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-outline-info"
                                    @click.prevent="editarDato(dato)"
                                >
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-danger"
                                    @click.prevent="eliminarDato(dato)"
                                >
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            datos: [],
            mensaje: "",
        };
    },
    methods: {
        getDatos() {
            let url = "/api/datosp";

            axios.get(url).then((response) => {
                // console.log(response.data);
                this.datos = response.data;
            });
        },
        async nuevoDato() {
            // console.log("Nuevo Dato");

            const steps = ["1", "2", "3", "4"];
            const results = {};
            const swalQueue = Swal.mixin({
                progressSteps: steps,
                confirmButtonText: "Next >",
            });

            await swalQueue.fire({
                title: "Escribe tu nombre completo:",
                text: "Nombre y Apellido",
                input: "text",
                inputValidator: (value) => {
                    if (!value) {
                        toastr.error("Debes digitar un nombre", "Error");
                        return " ";
                    }
                    results.nombre = value;
                    // results.push(value);
                },
                currentProgressStep: 0,
            });
            await swalQueue.fire({
                title: "Selecciona la posicion:",
                text: "Posicion de este empleado",
                input: "select",
                inputOptions: {
                    auditor: "auditor",
                    soporte: "soporte",
                    seguridad: "seguridad",
                },
                inputPlaceholder: "Selecciona una posicion",
                inputValidator: (value) => {
                    if (!value) {
                        toastr.error("Debes seleccionar una opcion", "Error");
                        return " ";
                    }
                    results.posicion = value;
                    // results.push(value);
                },
                currentProgressStep: 1,
            });

            await swalQueue
                .fire({
                    title: "Escribe el salario de este empleado",
                    text: "Este campo acepta decimales",
                    input: "text",
                    inputValidator: (value) => {
                        if (!value) {
                            toastr.error("Debes introducir salario", "Error");
                            return " ";
                        }
                        results.salario = value;
                        // results.push(value);
                    },
                    currentProgressStep: 2,
                    confirmButtonText: "OK",
                })
                .then(async (value) => {
                    if (value) {
                        const answers = JSON.stringify(results);

                        // console.log(results);

                        let url = "/api/datosp";

                        await axios.post(url, results).then((response) => {
                            this.mensaje = response.data;
                        });

                        Swal.fire({
                            title: "All done!",
                            /*
                            html: `
                            Your answers:
                            <pre><code>${answers}</code></pre>
                            `,
                            */
                            confirmButtonText: "Lovely!",
                        });

                        this.getDatos();
                        toastr.success(this.mensaje);
                    }
                });
        },

        eliminarDato(dato) {
            // console.log(dato);

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: true,
            });

            swalWithBootstrapButtons
                .fire({
                    title: "¿Estas seguro?",
                    html: `Si eliminas el registro de <strong>${dato.nombre}</strong>, <br>¡No podras revertir esto!`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Eliminar",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    reverseButtons: true,
                })
                .then(async (result) => {
                    // console.log(result);
                    // console.log(dato.id);
                    if (result.value) {
                        let url = `api/datosp/${dato.id}`;

                        await axios.delete(url).then((response) => {
                            console.log(response.data);
                            this.mensaje = response.data;
                        });

                        this.getDatos();
                        toastr.success(this.mensaje);

                        /*
                        swalWithBootstrapButtons.fire(
                            "Deleted!",
                            "Your file has been deleted.",
                            "success"
                        );
                        */
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        toastr.error("Accion cancelada");
                    }
                });
        },

        editarDato(dato) {
            console.log(dato);

            let formulario = `
                <div id="swal2-content" class="swal2-html-container" style="display: block;">Nombre y apellido:</div>
                <input class="swal2-input" id="nombre" name="nombre" type="text" style="display: flex;">

                <div id="swal2-content" class="swal2-html-container" style="display: block;">Posicion de este empleado:</div>
                <select class="swal2-select" id="posicion" name="posicion" style="display: flex;">
                    <option value="" disabled="">Selecciona una opcion</option>
                    <option value="auditor">Auditor</option>
                    <option value="soporte">Soporte</option>
                    <option value="seguridad">Seguridad</option>
                </select>

                <div id="swal2-content" class="swal2-html-container" style="display: block;">Salario</div>
                <input class="swal2-input" id="salario" name="salario" type="text" style="display: flex;">
            `;

            Swal.fire({
                title: "Editar Registro",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Guardar",
                html: formulario,
                focusConfirm: false,
                preConfirm: async () => {
                    let ultimosDatosEditados = {
                        nombre: document.getElementById("nombre").value,
                        posicion: document.getElementById("posicion").value,
                        salario: document.getElementById("salario").value,
                    };

                    let url = `/api/datosp/${dato.id}`;

                    await axios
                        .put(url, ultimosDatosEditados)
                        .then((response) => {
                            this.mensaje = response.data;
                        });

                    this.getDatos();
                    return toastr.success(this.mensaje);
                },
            });

            document.getElementById("nombre").value = dato.nombre;
            document.getElementById("posicion").value = dato.posicion;
            document.getElementById("salario").value = dato.salario;

            /*
            if (formValues) {
                Swal.fire(JSON.stringify(formValues));
            }
            */
        },
    },
    mounted() {
        this.getDatos();
    },
};
</script>
