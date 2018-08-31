<template id="template-collection-index">

    <article class="row">
        <div class="col s12">

            <!-- Table -->
            <div class="col s12">

                <card-main>
                    <card-content>
                        <div class="row">
                            <card-title class="col s12">
                                <h1>Colecciones</h1>
                            </card-title>

                            <!-- Table -->
                            <div class="col s12" v-if="options === 0">

                                <a href="#!" class="btn btn-success" @click="options = 1">Crear coleccion</a>

                                <table-byte :set-table="setTable">

                                    <table-row slot="table-head" slot-scope="{ item }">
                                        <table-head>Nombre del Curso</table-head>
                                        <table-head>Asignaturas</table-head>
                                        <table-head>Acciones</table-head>
                                    </table-row>

                                    <table-row slot="table-row" slot-scope="{ item }">
                                        <table-cell>{{ item.name }}</table-cell>
                                        <table-cell>{{ item.assignments.length }}</table-cell>
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

                                            <a :href="`${url}/${item.id}/reports`" target="_blank" title="Reporte PDF" class="btn-action">
                                                <img :src="'img/icons/ico-pdf.png' | asset" alt="" class="img-responsive">
                                            </a>
                                        </table-cell>
                                    </table-row>

                                    <table-row slot="empty-rows">
                                        <table-cell colspan="3">
                                            No se encontraron registros.
                                        </table-cell>
                                    </table-row>

                                </table-byte>
                            </div>

                            <!-- Modal -->
                            <byte-modal v-on:pressok="_delete" :confirm="modal.type.confirm">
                                <template v-if="modal.type.action == 'view'"></template>

                                <template v-if="modal.type.action == 'destroy'">
                                    <div class="container-confirmation">
                                        <div class="confimation__icon">
                                            <i class="material-icons">error_outline</i>
                                        </div>
                                        <div class="confirmation__text">
                                            <h5>¿Realmente desea <b>eliminar</b> este curso?</h5>
                                        </div>
                                    </div>
                                </template>
                            </byte-modal>
                        </div>

                        <collection-form v-if="options === 1"></collection-form>
                        <collection-form v-if="options === 2"></collection-form>

                    </card-content>
                </card-main>
            </div>
        </div>
    </article>
   
</template>

<script>

import CollectionForm from "./CollectionForm";

export default {
    template: "#template-collection-index",
    components: { CollectionForm },
    props: {
        url: {
            type: String,
            default: ""
        },
        collections: {
            type: Array,
            default(){
                return []
            }
        }
    },
    data() {
        return {
            options: 0,
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
            },
            setTable: []
        }
    },
    methods:{

        _view(data, action){
            this.modal.title = "Ver curso";
            this.modal.type.action = action;
            this.modal.type.confirm = false;
            this.modal.data = data;
            this.modal.init.open();
        },

        _edit(data, action){
            this.$emit('edit', {data: data, option: 1});
        },

        _confirm(data, action){
            this.modal.title = "Eliminar curso";
            this.modal.type.action = action;
            this.modal.type.confirm = true;
            this.modal.data = data;
            this.modal.init.open();
        },

        _delete() {
            let index = this.setTable.findIndex(e => {
                return e.id == this.modal.data.id
            })

            this.modal.init.close();

            axios.delete(`admin/courses-classes/${this.modal.data.id}`)
                .then(res => {
                    this.setTable.splice(index, 1)
                    swal('', 'Se ha eliminado el curso con éxito', "success");
                    this._back();
                })
                .catch(err => {
                    swal('', 'Disculpe, ha ocurrido un error', "error")
                });
        },

        _back(fast = false){
            if(fast){
                this.$emit('back', 0);
            }else{
                setTimeout(() => {
                    this.$emit('back', 0)
                }, 2000);
            }
        }
    },
    mounted () {
        this.modal.init = M.Modal.init(document.querySelector('.modal'));
    }
}
</script>
