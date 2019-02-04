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
                                    <table-cell>
                                        <template v-if="item.type == '1'">Natural</template>
                                        <template v-else>Jurídico</template>    
                                    </table-cell>
                                    <table-cell>{{ item.created_at | date }}</table-cell>
                                    <table-cell>{{ item.telefono }} </table-cell>
                                    <table-cell>
                                        <div class="switch">
                                            <label>
                                                <input type="checkbox">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                        <a href="#!" class="btn-action" @click="_view(item)">
                                            <img :src="'img/icons/ico-ver.png' | asset" alt="" class="img-responsive">
                                        </a>
                                        <a href="#!" class="btn-action" @click="_purchase(item)">
                                            <img :src="'img/icons/ico-purchase.png' | asset" alt="" class="img-responsive">
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
                                                                        
                                    <div class="col s12 m6" v-if="modal.data.type == 2"><b>Empresa:</b> {{ modal.data.empresa }}</div>
                                    <div class="col s12 m6"><b>Codigo postal:</b> {{ modal.data.codigo }}</div>
                                    <div class="col s12 m12"><b>Dirección:</b> {{ modal.data.direccion }}</div>
                                    <div class="col s12 m6" v-if="modal.data.pais"><b>Pais:</b> {{ modal.data.pais.nombre }}</div>
                                    <div class="col s12 m6"  v-if="modal.data.estado"><b>Estado:</b> {{ modal.data.estado.nombre }}</div>
                                </template>
                            </byte-modal>
                             <byte-modal id="purchase">
                                <template>
                                    <div class="col s12">
                                        <h3>Datos de los pedidos</h3>
                                    </div>
                                    <div class="col s12 underline" v-for="(pedido, i) in modalPurchase.data.pedidos" :key="'pedido-'+i">
                                        <div class="col s12 m3">
                                            <div class="col s12 m12"><b>N° de Pedido: {{ pedido.id }}</b></div>
                                        </div>
                                        <div class="col s12 m3">
                                            <div class="col s12 m12"><h6>Fecha: {{ pedido.created_at }}</h6></div>
                                        </div>
                                        <div class="col s12 m3">
                                            <div class="col s12 m12">
                                                <h6>
                                                    Tipo de pago: 
                                                    <template v-if="pedido.payment_type == '1'">Mercado Pago</template>
                                                    <template v-else-if="pedido.payment_type == '2'">Paypal</template>
                                                    <template v-else>Transferencia</template>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col s12 m3">
                                            <b>Total:</b>
                                             {{ getTotal(pedido) }}                                
                                             <b>{{pedido.payment_type == 2 ? 'USD' : 'Bs. S.'}}</b> 
                                        </div>                                                                            
                                    </div>
                                </template>
                            </byte-modal>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>

<style>
    .underline {
        border-bottom: 3px solid #000000;
        margin-bottom: 10px;
    }
</style>


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
            },
            modalPurchase: {
                init: '',
                data: {},
                type: {
                    action: 'purchase'
                }
            },
            total: ''
        }
    },
    methods: {
        _view(item){
            this.modal.data = item;
            this.modal.init.open();
        },
        _purchase(item) {
            this.dataTable.forEach(element => {
                
            });
            this.modalPurchase.data = item;
            this.modalPurchase.init.open();
        },
        getTotal (item) {
            let total = 0
                
            let subtotal = 0; 
            let price = 0;
            item.details.forEach(e => {
                if(item.payment_type == 2) { // Si es PAYPAL

                    if(e.coin == 1) {
                        price = parseFloat(e.price / item.exchange.change).toFixed(2)
                    }else {
                        price = e.price
                    }
                    
                }else {

                    if(e.coin == 1) {
                        price = e.price
                    }else {
                        price = parseFloat(e.price * item.exchange.change).toFixed(2)
                    }

                }
                subtotal = price * e.quantity
                
                total += subtotal
            })

            return total.toFixed(2)
        },
        /*getTotal (item) {
            let total = 0
            item.details.forEach(e => {
                total += e.price;
            })
            return total
        },*/
        getPrice(precio,coin,exchange, pay) {
            var price = precio;
            if (coin == '1' && pay == '2') {
                price = parseFloat(price / exchange).toFixed(2);
            }
            else if (coin == '2' && pay == '1') {
                price = parseFloat(price * exchange).toFixed(2);
            }
            return price;
        },
        findCurrency (item) {
            let currency = 1
            item.details.forEach(e => {
                currency = e.coin
            })

            return currency == 1 ? 'Bs. S' : 'USD'
        }
    },
    mounted () {
        this.dataTable = this.clients
        this.modal.init = M.Modal.init(document.querySelector('.modal'));
        this.modalPurchase.init = M.Modal.init(document.querySelector('#purchase'));
    }
}
</script>
