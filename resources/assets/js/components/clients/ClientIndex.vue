<template>
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1>Clientes</h1>
            </div>
            <div class="row">
                <div class="col s12">
                    <section class="table__content">
                        <div class="row">
                             <table-byte :set-table="dataTable" :filters="['name']">
                                <table-row slot="table-head" slot-scope="{ item }">
                                    <table-head>Nombre</table-head>
                                    <table-head>Identificación</table-head>
                                    <table-head>Tipo</table-head>
                                    <table-head>Fecha de registro</table-head>
                                    <table-head>Teléfono</table-head>
                                    <table-head>Acciones</table-head>
                                </table-row>

                                <table-row slot="table-row" slot-scope="{ item }">
                                    <table-cell>{{ item.name }}</table-cell>
                                    <table-cell>{{ item.identificacion }}</table-cell>
                                    <table-cell>{{ item.type }}</table-cell>
                                    <table-cell>{{ item.created_at | date }}</table-cell>
                                    <table-cell>{{ item.telefono }} </table-cell>
                                    <table-cell>
                                        <a href="#!" class="btn-action" @click="_view(item)">
                                            <img :src="'img/icons/ico-ver.png' | asset" alt="" class="img-responsive">
                                        </a>
                                    </table-cell>
                                </table-row>

                                <table-row slot="empty-rows">
                                    <table-cell colspan="3">
                                        No se encontraron registros.
                                    </table-cell>
                                </table-row>

                            </table-byte>

                            <byte-modal>
                                <template>
                                    <div class="col s12">
                                        <h3>Datos del cliente</h3>
                                    </div>
                                    
                                    <div class="col s12 m6"><b>Nombre:</b> {{ modal.data.name }}</div>
                                    <div class="col s12 m6"><b>Identificación:</b> {{ modal.data.identificacion }}</div>
                                    
                                    <div class="col s12 m6"><b>Telefono:</b> {{ modal.data.telefono }}</div>
                                    <div class="col s12 m6"><b>Correo electrónico:</b> {{ modal.data.email }}</div>
                                                                        
                                    <div class="col s12 m6" v-if="modal.data.nivel == 2"><b>Empresa:</b> {{ modal.data.empresa }}</div>
                                    <div class="col s12 m6"><b>Codigo postal:</b> {{ modal.data.codigo }}</div>
                                    
                                    <div class="col s12 m12"><b>Dirección:</b> {{ modal.data.direccion }}</div>
                                    
                                    <div class="col s12 m6" v-if="modal.data.pais"><b>Pais:</b> {{ modal.data.pais.nombre }}</div>
                                    <div class="col s12 m6"  v-if="modal.data.estado"><b>Estado:</b> {{ modal.data.estado.nombre }}</div>
                                    
                                </template>

                    </byte-modal>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: '',
    props: {
        clients: {
            type: Array,
            default: []
        },
    },
    data () {
        return {
            dataTable: [],
            modal: {
                init: '',
                data: {},
                type: {
                    action: 'view'
                }
            }
        }
    },
    methods: {
        _view(item){
            this.modal.data = item;
            this.modal.init.open();
        },
    },
    mounted () {
        console.log(this.clients)
        this.dataTable = this.clients
        this.modal.init = M.Modal.init(document.querySelector('.modal'));
    }
}
</script>
