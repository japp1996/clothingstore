<template id="template-product-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1>Cuentas bancarias</h1>
            </div>
        </div>
        <div class="row" v-if="options == 0">
            <div class="col s12">
                <section class="table__content" >
                    <div class="row">
                        <a class="col s12 container-btn-add"  @click="options = 1">
                            <button class="btn-add">
                                 <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                            </button>
                            <div class="btn-add-text">
                                Agregar nuevo
                            </div>                            
                        </a>
                    </div>

                    <table-byte :set-table="dataTable" :filters="['name']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>Cuenta</table-head>
                            <table-head>Banco</table-head>
                            <table-head>Acciones</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.name }}</table-cell>
                            <table-cell>{{ item.bank.name }}</table-cell>
                            <table-cell>
                                <!-- <a href="#!" class="btn-action" @click="_view(item)">
                                    <img :src="'img/icons/ico-ver.png' | asset" alt="" class="img-responsive">
                                </a> -->

                                <a href="#!" class="btn-action" @click="_edit(item)">
                                    <img :src="'img/icons/ico-editar.png' | asset" alt="" class="img-responsive">
                                </a>

                                <a href="#!" class="btn-action" @click="_confirm(item, 'postear')">
                                    <img :src="'img/icons/ico-toggle-on.svg' | asset" alt="" class="img-responsive" style="width: 36px; margin: 0;" v-if="item.status == '1'">
                                    <img :src="'img/icons/ico-toggle-off.svg' | asset" alt="" class="img-responsive" style="width: 36px; margin: 0;" v-if="item.status == '0'">
                                </a>

                                <a href="#!" class="btn-action" @click="_confirm(item, 'delete')">
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
        <byte-modal v-on:pressok="modal.action" :confirm="modal.type.confirm">

            <template v-if="modal.type.action == 'delete'">
                <div class="container-confirmation">
                    <div class="confimation__icon">
                        <i class="material-icons">error_outline</i>
                    </div>
                    <div class="confirmation__text">
                        <h5>¿ Realmente deseas <b>Eliminar</b> este Producto ?</h5>
                    </div>
                </div>
            </template>

            <template v-else-if="modal.type.action == 'postear'">
                <div class="container-confirmation">
                    <div class="confimation__icon">
                        <i class="material-icons">error_outline</i>
                    </div>
                    <div class="confirmation__text">
                        <h5>¿ Realmente deseas <b>{{ modal.data.status == 1 ? 'Desactivar ' : 'Publicar' }}</b> este Producto ?</h5>
                    </div>
                </div>
            </template>
        </byte-modal>

        <bank-form v-if="options == 1" @back="options = 0"></bank-form>
    </section>
</template>

<style lang="scss">
    .img-products{
        height: 80%;
        width: 80%;
        object-fit: contain
    }
</style>

<script>
import BankForm from './BankForm'

export default {
    template: "#template-product-index",
    props: {
        banks: {
            type: Array,
            default: []
        }
    },
    components: {
        BankForm
    },
    created (){
        this.dataTable = this.banks
    },

    data () {
        return {
            options: 0,
            form: {},
            dataTable: [],
            filters: [],
            modal: {
                init: {},
                title: "",
                type: {
                    confirm: false,
                    action: 'view'
                },
                action: {},
                data: {
                    collections: {},
                    categories: {},
                    subcategories: {},
                    designs: {}
                }
            }
        }
    },

    methods: {

        _resetView (option) {
            this.options = option
        },

        _view(item){
            console.log(item);
            this.modal.type.confirm = false;
            this.modal.type.action = "view";
            this.modal.data = item;
            this.modal.init.open();
        },

        _confirm(item, action) {
            this.modal.type.confirm = true;
            this.modal.type.action = this._delete;
            this.modal.data = item;

            if(action == "delete"){
                this.modal.type.action = "delete";
                this.modal.action = this._delete;
            }

            if(action == "postear"){
                this.modal.type.action = "postear";
                this.modal.action = this._postear;
            }

            this.modal.init.open();
        },

        _edit(item) {
            this.options = 2
            this.form = item
        },

        _delete(){
            let index = this.dataTable.findIndex(e => {
                return e.id == this.modal.data.id
            })
            
            this.modal.init.close();

            axios.delete(`admin/products/${this.modal.data.id}`)
                .then(res => {
                    this.dataTable.splice(index, 1)
                    this._showAlert(res.data.message, "success");
                })
                .catch(err => {
                    this._showAlert('Disculpa, ha ocurrido un error', "error")
                });
        },

        _postear(){
            let index = this.dataTable.findIndex(e => {
                return e.id == this.modal.data.id
            })
            
            this.modal.init.close();

            axios.post(`admin/product/postear/${this.modal.data.id}`)
                .then(res => {
                    console.log(this.dataTable[index]);
                    this.dataTable[index].status = res.data.status;
                    // this..splice(index, 1);
                    swal("", res.data.message, "success");
                    // this._showAlert(res.data.message, "success");
                })
                .catch(err => {
                    this._showAlert('Disculpa, ha ocurrido un error', "error")
                });
        },

        _updateData() {
            axios.get('admin/products-all')
            .then(res => {
                this.dataTable = res.data
            })
            .catch(err => {
                console.log(err)                
            })
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

    mounted () {
        this.modal.init = M.Modal.init(document.querySelector('.modal'));
    }
}
</script>
