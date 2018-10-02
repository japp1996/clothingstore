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
                                <a href="#!" class="btn-action" @click="_view(item)">
                                    <img :src="'img/icons/ico-ver.png' | asset" alt="" class="img-responsive">
                                </a>

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

                <product-form v-if="options == 1" @back="_resetView" @reload="_updateData" :categories="categories" :designs="designs" :collections="collections"></product-form>
                <product-edit v-if="options == 2" @back="_resetView" :data="form" :categories="categories" :designs="designs" :collections="collections" @reload="_updateData"></product-edit>
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

            <template v-else>
                <div class="col s12">
                    <h3>Información del Producto</h3>
                </div>

                <div class="col s12 m6">
                    <span>Producto (Español):</span> {{ modal.data.name }}
                </div>
                <div class="col s12 m6">
                    <span>Producto (Ingles):</span> {{ modal.data.name_english }}
                </div>

                <div class="col s12 m6">
                    <span>Descripción (Español):</span> {{ modal.data.description }}
                </div>

                <div class="col s12 m6">
                    <span>Descripción (Ingles):</span> {{ modal.data.description }}
                </div>

                <div class="col s12 m6">
                    <span>Precio (Detal):</span> {{ modal.data.coin == "1" ? '$' : "Bs. S" }}{{ modal.data.price_1 }}
                </div>

                <div class="col s12 m6">
                    <span>Precio (Mayor):</span> {{ modal.data.coin == "1" ? '$' : "Bs. S" }}{{ modal.data.price_2 }}
                </div>

                <div class="col s12 m6">
                    <span>Tipo de venta: </span> {{ modal.data.retail == "1" ? 'Detal' : "Mayor" }}
                </div>

                <div class="col s12">
                    <h3>Diseño</h3>
                </div>

                <div class="col s12 m6">
                    <span>Diseño (Español): </span> {{ modal.data.designs.name }}
                </div>

                <div class="col s12 m6">
                    <span>Diseño (Ingles): </span> {{ modal.data.designs.name_english }}
                </div>

                <div class="col s12">
                    <h3>Colecciones</h3>
                </div>

                <div class="col s12 m6">
                    <span>Colecciones (Español): </span> {{ modal.data.collections.name }}
                </div>

                <div class="col s12 m6">
                    <span>Colecciones (Ingles): </span> {{ modal.data.collections.name_english }}
                </div>

                <div class="col s12">
                    <h3>Colores</h3>
                </div>

                <div class="col s12" v-for="(color, i) in modal.data.colors" :key="'color-' + i">
                    <div class="col s12 m6 no-padding">
                        <span>Color (Español): </span> {{ color.name }}
                    </div>

                    <div class="col s12 m6 no-padding">
                        <span>Color (Ingles): </span> {{ color.name_english }}
                    </div>
                </div>

                <div class="col s12">
                    <h3>Categoría</h3>
                </div>

                <div class="col s12 m6">
                    <span>Categoría (Ingles): </span> {{ modal.data.categories.name }}
                </div>

                <div class="col s12 m6">
                    <span>Categoría (Ingles): </span> {{ modal.data.categories.name_english }}
                </div>

                <div class="col s12">
                    <h3>Subcategoría</h3>
                </div>

                <div class="col s12 m6">
                    <span>Subcategoría (Ingles): </span> {{ modal.data.subcategories.name }}
                </div>

                <div class="col s12 m6">
                    <span>Subcategoría (Ingles): </span> {{ modal.data.subcategories.name_english }}
                </div>

                <div class="col s12">
                    <h3>Imagenen Principal</h3>
                </div>

                <div class="col s12 m6" v-for="(img, i) in modal.data.images" :key="'img-main' + i" v-if="img.main == 1">
                    <img class="img-products" :src="`img/products/${img.file}` | asset" alt="">
                </div>

                <div class="col s12">
                    <h3>Imagenenes Secundarias</h3>
                </div>

                <div class="col s12 m6" v-for="(img, i) in modal.data.images" :key="'img-main' + i" v-if="img.main == 0">
                    <img class="img-products" :src="`img/products/${img.file}` | asset" alt="">
                </div>
            </template>

        </byte-modal>
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
import ProductForm from './ProductForm';
import ProductEdit from './ProductEdit';
export default {
    template: "#template-product-index",
    components: {ProductForm, ProductEdit},
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
