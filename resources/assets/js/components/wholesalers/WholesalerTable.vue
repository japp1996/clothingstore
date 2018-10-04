<template id="template-wholesaler-index">
    <article>
        <div class="row">
            <div class="col s12 center-align">
                <h1>Colecciones mayoristas</h1>
            </div>
        </div>

        <!-- TABLA DE REGISTROS -->
        <div class="row">
            <div class="col s12">
                <section class="table__content">
                    <div class="row">
                        <a href="#" class="col s12 container-btn-add" @click="setOption(2)">
                            <button class="btn-add">
                                <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                            </button>
                            <div class="btn-add-text">
                                Agregar nuevo
                            </div>       
                        </a>
                    </div>
                    <table-byte :set-table="wholesalers" :filters="[]">
                        <table-row slot="table-head">
                            <table-head class="th">Nombre </table-head>
                            <table-head>Cantidad</table-head>
                            <table-head>Precio</table-head>
                            <table-head>Moneda</table-head>
                            <table-head>Descripción</table-head>
                            <table-head>Acción</table-head>

                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.name }}</table-cell>
                            <table-cell>{{ item.quantity }}</table-cell>
                            <table-cell>{{ item.price }}</table-cell>
                            <table-cell>{{ item.coin }}</table-cell>
                            <table-cell>{{ item.description }}</table-cell>
                            <table-cell class="icon-margin">

                                <a href="#!" class="btn-action" @click="_view(item)">
                                    <img :src="'img/icons/ico-ver.png' | asset" alt="" class="img-responsive">
                                </a>

                                <a :href="`/${item.id}/edit`" class="btn-action">
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
                    
                    <!-- <byte-modal v-on:pressok="_delete" :confirm="modal.type.confirm">
                        <template v-if="modal.type.action == 'view'">
                            <div class="col s12">
                                <h3>Detalles del Blog</h3>
                            </div>
                            <div class="col s12 m6">
                                <div class="col s12">
                                    <h3>Nombre</h3>
                                </div>
                                <div class="col s12">
                                    {{ modal.data.name }}
                                </div>
                                <div class="col s12">
                                    <h3>Cantidad</h3>
                                </div>      
                                <div class="col s12">
                                    {{ modal.data.quantity }}
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="col s12">
                                    <h3>Precio</h3>
                                </div>
                                <div class="col s12">
                                    {{ modal.data.price }}
                                </div>
                                <div class="col s12">
                                    <h3>Moneda</h3>
                                </div>
                                <div class="col s12">
                                    {{ modal.data.coin }}
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="col s12">
                                    <h3>Nombre (Inglés)</h3>
                                </div>
                                <div class="col s12">
                                    {{ modal.data.name_english }}
                                </div>
                                <div class="col s12">
                                    <h3>Descripción (Inglés)</h3>
                                </div>
                                <div class="col s12">
                                    {{ modal.data.description_english }}
                                </div>
                            </div>              
                            <div class="col s12">
                                <h3>Imágenes</h3>
                            </div>
                            <div class="col s12 m6" v-for="(img,i) in modal.data.images" :key="'img-' + i">
                                <img :src="'img/blogs/' + img.file | asset " class="img-width"  alt="">
                            </div>
                        </template>
                        <template v-else>
                            <div class="container-confirmation">
                                <div class="confimation__icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <div class="confirmation__text">
                                    <h5>¿ Realmente deseas <b>Eliminar</b> ésta Colección ?</h5>
                                </div>
                            </div>
                        </template>
                    </byte-modal> -->
                </section>
            </div>
        </div>
    </article>
</template>

<script>
import { mapState } from 'vuex'

export default {
    template: "#template-wholesaler-index",
    data(){
        return {
            // setTable: [],
            modal: {
                init: {},
                title: "",
                type: {
                    confirm: false,
                    action: "view"
                },
                data: {}
            }
        }
    },
    computed: mapState({
        wholesalers: state => state.wholesalers.all
    }),
    methods: {
        setOption (option) {
            this.$store.dispatch('wholesalers/changeOption', option)
        },
        _view(item){
            this.modal.type.confirm = false;
            this.modal.type.action = "view";
            this.modal.data = item;
            this.modal.init.open();
        },

        _confirm(item){
            this.modal.type.confirm = true;
            this.modal.type.action = "destroy";
            this.modal.data = item;
            this.modal.init.open();
        },
        _delete() {

        }
    },

    mounted() {
        this.modal.init = M.Modal.init(document.querySelector('.modal'));
        this.$store.commit('wholesalers/setWholesalers', this.wholesaler)
    }
}
</script>


