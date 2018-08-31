<template id="template-size-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1>Tallas</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <section class="table__content">
                    <div class="row">
                        <div class="col s12 container-btn-add">
                            <button class="btn-add">
                                 <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                            </button>
                            <div class="btn-add-text">
                                Agregar nueva
                            </div>                            
                        </div>
                    </div>
                    <table-byte :set-table="sizesArray" :filters="['name']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>Nombre de la talla</table-head>
                            <table-head>Acciones</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.name }}</table-cell>
                            <table-cell>

                                <a href="#!" class="btn-action" @click="_view(item, 'view')">
                                    <img :src="'img/icons/ico-ver.png' | asset" alt="" class="img-responsive">
                                </a>

                                <a href="#!" class="btn-action" @click="_edit(item, 'edit')">
                                    <img :src="'img/icons/ico-editar.png' | asset" alt="" class="img-responsive">
                                </a>

                                <a href="#!" class="btn-action" @click="_confirm(item, 'destroy')">
                                    <img :src="'img/icons/ico-eliminar.png' | asset" alt="" class="img-responsive">
                                </a>

                            </table-cell>
                        </table-row>

                        <table-row slot="empty-rows">
                            <table-cell colspan="3">
                                No se encontraron registros.
                            </table-cell>
                        </table-row>

                    </table-byte>
                </section>
            </div>
        </div>
    </section>
</template>

<style lang="scss">

</style>

<script>
export default {
    template: "#template-size-index",

    props: {
        url: {
            type: String,
            default () {
                return ""
            }
        },

        sizes: {
            type: Array,
            default () {
                return []
            }
        }
    },

    created () {
        this.sizesArray = this.sizes
    },

    data () {
        return {
            sizesArray: [],
            form: {
                id: 0,
                name: ""
            }
        }
    }
}
</script>

