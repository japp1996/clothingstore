<template id="template-blog-index">
    <section class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col s12 center-align">
                    <h1 v-if="options == 0">Categorías</h1>
                    <h1 v-if="options == 1 || options == 2">{{ options == 1 ? 'Registrar' : 'Actualizar' }} Categoría</h1>
                </div>
            </div>
            <div class="col s12">
                <section class="table_content">
                    <div class="row">
                        <div class="col s12">

                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col s12">

            </div>
        </div>
    </section>
</template>

<script>
export default {
    template:"#template-blog-index",
}
</script>


