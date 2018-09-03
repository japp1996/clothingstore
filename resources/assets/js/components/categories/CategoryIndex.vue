<template id="template-category-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1 v-if="options == 0">Categorías</h1>
                <h1 v-if="options == 1 || options == 2">{{ options == 1 ? 'Registrar' : 'Actualizar' }} Categoría</h1>
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
                                Agregar nueva
                            </div>                            
                        </div>
                    </div>
                    <table-byte :set-table="dataTable" :filters="['name']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>Nombre de la categoría</table-head>
                            <table-head>Acciones</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.name }}</table-cell>
                            <table-cell>

                                <a href="#!" class="btn-action" @click="_edit(item, 'view')">
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
                <category-add v-if="options == 1" :sizes="sizes" @back="_resetView"></category-add>
            </div>
        </div>
        <byte-modal v-on:pressok="modal.type.action" :confirm="modal.type.confirm">
            <div class="container-confirmation">
                <div class="confimation__icon">
                    <i class="material-icons">error_outline</i>
                </div>
                <div class="confirmation__text">
                    <h5>¿ Realmente deseas <b>Eliminar</b> esta categoría ?</h5>
                </div>
            </div>
        </byte-modal>
    </section>
</template>

<style lang="scss">

</style>

<script>

import CategoryAdd from './CategoryAdd';

export default {
    template: "#template-category-index",
    components: {CategoryAdd},
    props: {
        url: {
            type: String,
            default: ""
        },

        categories: {
            type: Array,
            default () {
                return []
            }
        },

        sizes: {
            type: Array,
            default () {
                return []
            }
        },
    },

    created () {
        this.dataTable = this.sizes
    },

    data () {
        return {
            options: 0,
            dataTable: [],
            filters: [],
            filter: "",
            modal: {
                init: {},
                title: "",
                type: {
                    confirm: false,
                    action: 'view'
                },
                data: {
                    name: ''
                }
            }
        }
    },

    methods: {
        _resetView(option) {
            this.options = option
        }
    }
}
</script>

