<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
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
                            <td>@mdo</td>
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
            mensaje: "Esto es una prueba",
        };
    },
    methods: {
        getDatos() {
            let url = "/api/datosp";

            axios.get(url).then((response) => {
                console.log(response.data);
                this.datos = response.data;
            });
        },
    },
    mounted() {
        this.getDatos();
    },
};
</script>
