<template id="template-change-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1 v-if="options == 0">Tasa de Cambio</h1>
                <h1 v-if="options == 1">Nueva Tasa de Cambio</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <section class="table__content" v-if="options == 0">
                    <div class="row">
                        <div class="col s12 container-btn-add">
                            <button class="btn-add" @click="options = 1">
                                 <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                            </button>
                            <div class="btn-add-text">
                                Agregar nuevo
                            </div>                            
                        </div>
                    </div>

                    <table-byte :set-table="dataTable" :filters="['change']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>Tasa de cambio</table-head>
                            <table-head>Fecha</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.change }}</table-cell>
                            <table-cell>{{ item.date }}</table-cell>
                        </table-row>

                        <table-row slot="empty-rows">
                            <table-cell colspan="3">
                                No se encontraron registros.
                            </table-cell>
                        </table-row>

                    </table-byte>
                </section>
                <change-form v-if="options == 1" @back="_resetView"></change-form>
            </div>
        </div>
    </section>
</template>

<style lang="scss">

</style>

<script>
export default {
    props: {
        changes: {
            type: Array,
            default: []
        }
    },

    created () {
        this.dataTable = this.changes        
    },

    data () {
        return {
            form: {
                id: 0,
                change: 0.00
            },
            dataTable: [],
            options: 0
        }
    },

    methods: {
        _resetView (option) {
            this.options = option
        },
    },

    mounted () {

    }
}
</script>

