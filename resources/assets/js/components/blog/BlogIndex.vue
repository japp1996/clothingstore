<template id="template-blog-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1>Blogs</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <section class="table_content">
                    <div class="row">
                        <a :href="url + '/create'" class="col s12 container-btn-add">
                            <button class="btn-add">
                                <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                            </button>
                            <div class="btn-add-text">
                                Agregar nuevo
                            </div>       
                        </a>
                    </div>
                    <table-byte :set-table="setTable" :filters="['title', 'description']">
                        <table-row slot="table-head">
                            <table-head>Título </table-head>
                            <table-head>Descripción</table-head>
                            <table-head>Acción</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.title }}</table-cell>
                            <table-cell>{{ item.description_min }}</table-cell>
                            <table-cell>

                                <a href="#!" class="btn-action" @click="_view(item, 'view')">
                                    <img :src="'img/icons/ico-ver.png' | asset" alt="" class="img-responsive">
                                </a>

                                <a :href="`${url}/${item.id}/edit`" class="btn-action">
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
                    
                    <byte-modal v-on:pressok="modal.type.action" :confirm="modal.type.confirm">
                        <template v-if="modal.type.action == 'view'">
                            <div class="col s12">
                                <h3>Título</h3>
                            </div>
                            <div class="col s12">
                                <h3>Descripción</h3>
                            </div>
                            <div class="col s12">
                                <h3>Título (Inglés)</h3>
                            </div>
                        </template>
                        <template v-else>
                            <div class="container-confirmation">
                                <div class="confimation__icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <div class="confirmation__text">
                                    <h5>¿ Realmente deseas <b>Eliminar</b> este Producto ?</h5>
                                </div>
                            </div>
                        </template>
                    </byte-modal>
                
                </section>
            </div>
        </div>


    </section>
</template>
<script>
export default {
    template: "#template-blog-index",

    data(){
        return {
            setTable: []
        }
    },

    methods: {
        _view(item){
            console.log(item);
            this.modal.type.confirm = false;
            this.modal.type.action = "view";
            this.modal.data = item;
            this.modal.init.open();
        },

        _confirm(item, destroy){

        }
    },
    
    props: {
        url: {
            type: String,
            default: ""
        },
        posts: {
            type: Array,
            default(){
                return [];
            }
        }
    },
    
    mounted() {
        this.setTable = this.posts;
        this.modal.init = M.Modal.init(document.querySelector('.modal'));
    }
}
</script>