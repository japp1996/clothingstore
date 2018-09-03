<template id="template-product-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1 v-if="options == 0">Productos</h1>
                <h1 v-if="options == 1 || options == 2">{{ options == 1 ? 'Agregar' : 'Actualizar'}} Producto</h1>
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

                    <table-byte :set-table="dataTable" :filters="['name']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>Producto</table-head>
                            <table-head>Acciones</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.name }}</table-cell>
                            <table-cell>
                                <a href="#!" class="btn-action" @click="_edit(item, 'edit')">
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

                <product-form v-if="options == 1" @back="_resetView" @reload="_updateData" :categories="categories" :designs="designs" :collections="collections"></product-form>
                <product-form v-if="options == 2" @back="_resetView" :action="1" :data="form" :categories="categories" :designs="designs" :collections="collections" @reload="_updateData"></product-form>
            </div>
        </div>
        <byte-modal v-on:pressok="modal.type.action" :confirm="modal.type.confirm">
            <div class="container-confirmation">
                <div class="confimation__icon">
                    <i class="material-icons">error_outline</i>
                </div>
                <div class="confirmation__text">
                    <h5>¿ Realmente deseas <b>Eliminar</b> este Producto ?</h5>
                </div>
            </div>
        </byte-modal>
    </section>
</template>

<style lang="scss">

</style>

<script>
import ProductForm from './ProductForm';
export default {
    template: "#template-product-index",
    components: {ProductForm},
    props: {
        categories: {
            type: Array,
            default: []
        },

        designs: {
            type: Array,
            default: []
        },

        collections: {
            type: Array,
            default: []
        },

        products: {
            type: Array,
            default: []
        }
    },

    created (){
        this.dataTable = this.products
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
                data: {
                    name: ''
                }
            }
        }
    },

    methods: {

        _resetView (option) {
            this.options = option
        },

        _confirm(item) {
            this.modal.type.confirm = true;
            this.modal.type.action = this._delete;
            this.modal.data = item;
            this.modal.init.open();
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

    }
}
</script>
