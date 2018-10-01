<template id="template-allies-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1 v-if="options == 0">Aliados</h1>
                <h1 v-if="options == 1 || options == 2">{{ options == 1 ? 'Registrar' : 'Actualizar' }} Aliado</h1>
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

                    <table-byte :set-table="allies" :filters="['nombre', 'facebook', 'twitter', 'instagram']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>Nombre </table-head>
                            <table-head>Facebook</table-head>
                            <table-head>Twitter </table-head>
                            <table-head>Instagram</table-head>
                            <table-head>Acciones</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.nombre }}</table-cell>
                            <table-cell>{{ item.facebook }}</table-cell>
                            <table-cell>{{ item.twitter }}</table-cell>
                            <table-cell>{{ item.instagram }}</table-cell>
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
                            <table-cell colspan="5">
                                No se encontraron registros.
                            </table-cell>
                        </table-row>

                    </table-byte>
                </section>

                <allies-add v-if="options == 1" @back="_resetView"></allies-add>
                <allies-update v-if="options == 2" :data="form" @back="_resetView"></allies-update>
            </div>
        </div>
        <!-- Modal -->
        <byte-modal v-on:pressok="_delete" :confirm="modal.type.confirm">
            <div class="container-confirmation">
                <div class="confimation__icon">
                    <i class="material-icons">error_outline</i>
                </div>
                <div class="confirmation__text">
                    <h5>¿Realmente deseas <b>eliminar</b> este aliado ?</h5>
                </div>
            </div>            
        </byte-modal>

    </section>
</template>

<style lang="scss">
    textarea{
        resize: none; 
        height: 10rem !important;
    }
    .items__file{
        position: relative;
    }
</style>


<script>
import AlliesAdd from './AlliesAdd'
import AlliesUpdate from './AlliesUpdate'

export default {
    template: "#template-allies-index",

    components: {AlliesAdd, AlliesUpdate},

    props: {
        allies: {
            type: Array,
            default () {
                return []
            }
        }
    },

    data () {
        return {
            options: 0,
            form: {},
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
        }
    },

    methods: {
        _resetView(e) {
            this.options = e
        },

        _edit (item, name = null) {
            this.form = item
            this.options = 2
        },

        _confirm(item) {
            this.modal.type.confirm = true;
            this.modal.type.action = this._delete;
            this.modal.data = item;
            this.modal.init.open();
        },

        _delete () {
            let index = this.allies.findIndex(e => {
                return e.id == this.modal.data.id
            })
            
            this.modal.init.close();

            axios.delete(`admin/allies/${this.modal.data.id}`)
                .then(res => {
                    this.allies.splice(index, 1)
                    this._showAlert(res.data.message, "success");
                })
                .catch(err => {
                    this._showAlert('Disculpa, ha ocurrido un error', "error")
                });
        },

        _showAlert(text, type) {
            swal({
                title: "",
                text: text,
                timer: 3000,
                showConfirmButton: false,
                type: type
            })
        }

    },

    mounted() {
        this.modal.init = M.Modal.init(document.querySelector('.modal'));
    }
}
</script>


