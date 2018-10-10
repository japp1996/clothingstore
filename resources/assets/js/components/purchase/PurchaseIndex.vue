<template>
    <section class="container-fluid">
        <div class="row">
            <div class="col s12 center-align">
                <h1>Pedidos</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <section class="table__content">
                    <div class="row">

                        <div class="col s12 m3">
                            <input type="text" class="datepicker browser-default input-impegno" placeholder="Fecha inicio" id="date_picker_init" v-model="init">
                        </div>
                        <div class="col s12 m3">
                            <input type="text" class="datepicker browser-default input-impegno" placeholder="Fecha final" id="date_picker_end" v-model="end">
                        </div>

                        <div class="col s1" style="cursor: pointer">
                            <i class="material-icons" @click="_refresh">refresh</i>
                        </div>

                        <div class="col s12 m3">
                            <button type="button" class="btn btn-success" @click="_search">Consultar</button>
                        </div>
                    </div>

                    <table-byte :set-table="dataTable" :filters="['user.name', 'code']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>ID/Referencia de la transacción </table-head>
                            <table-head>Fecha</table-head>
                            <table-head>Cliente</table-head>
                            <table-head>Total</table-head>
                            <table-head>Medio de pago</table-head>
                            <table-head>Acciones</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.code }}</table-cell>
                            <table-cell>{{ item.created_at | date }}</table-cell>
                            <table-cell>{{ item.user.name }}</table-cell>
                            <table-cell>{{ getTotal(item) }} {{ item.payment_type == 2 ? 'USD' : 'Bs. S.' }}</table-cell>
                            <table-cell>{{ pay_types[item.payment_type] }}</table-cell>
                            <table-cell class="head-actions">
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
                                <h3>Detalle del pedido</h3>
                            </div>
                            
                            <div class="col s12 m12"><b>ID transacción:</b> {{ modal.data.transaction_code }}</div>
                            <div class="col s12 m6" v-if="modal.data.user"><b>Cliente:</b> {{ modal.data.user.name }}</div>
                            <div class="col s12 m6"><b>Fecha:</b> {{ modal.data.created_at | date }}</div>
                            <div class="col s12 m12"><b>Medio de pago:</b> {{ pay_types[modal.data.payment_type] }}</div>
                            <div class="col s12 m6" v-if="modal.data.payment_type == 3"><b>Banco origen:</b> {{ modal.data.transfer.from.name }} </div>
                            <div class="col s12 m6" v-if="modal.data.payment_type == 3"><b>Banco destino:</b> 
                                {{ modal.data.transfer.to.bank.name }} -
                                {{ modal.data.transfer.to.name }} - 
                                {{ modal.data.transfer.to.identification }} 
                            </div>
                            <!-- <div class="col s12 m6"></div> -->
                            <div class="col s12">
                                <table>
                                    <thead>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>subtotal</th>
                                    </thead>
                                    <tbody v-if="modal.data.details">
                                        <tr v-for="(d,i ) in modal.data.details" :key="i">
                                            <td>{{ d.producto.name}}</td>
                                            <td>{{ getPrice(d.price, d.coin, modal.data.exchange.change, modal.data.payment_type) }}</td>
                                            <td>{{ d.quantity }}</td>
                                            <td>{{ parseFloat(getPrice(d.price, d.coin, modal.data.exchange.change, modal.data.payment_type) * d.quantity).toFixed(2) }}  {{ modal.data.payment_type == 2 ? 'USD' : 'Bs. S.' }}</td>
                                           
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="right-align"><b>Total</b></td>
                                            <td>{{ getTotal(modal.data) }} {{ modal.data.payment_type == 2 ? 'USD' : 'Bs. S.' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>

                    </byte-modal>
                </section>
            </div>
        </div>
    </section>
</template>

<style>
    .sweet-alert {
        z-index: 99999999;
    }
</style>


<script>
export default {
    name: 'purchase-index',
    props: {
        purchases: {
            type: Array,
            default: []
        }
    },
    data () {
        return {
            dataTable: [],
            init: '',
            end: '',
            pay_types: ['', 'MercadoPago', 'Paypal', 'Transferencia'],
            modal: {
                init: '',
                initErr: false,
                endErr: false,
                data: {},
                type: {
                    action: 'view'
                }
            }
        }
    },
    methods: {
        _refresh () {
            this.dataTable = this.purchases
            this.init = ''
            this.end = ''
        },

        _view(item){
            this.modal.data = item;
            this.modal.init.open();
        },

        findCurrency (item) {
            let currency = 1
            item.details.forEach(e => {
                currency = e.coin
            })

            return currency == 1 ? 'Bs. S' : 'USD'
        },

       
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
        _search () {
            if(!this.init || !this.end) {
                swal('', 'Debe seleccionar una fecha de inicio y de fin', 'error')
                return
            }
            axios.get(`admin/purchases/${this.init}/${this.end}/date`)
                .then(res => {
                    this.dataTable = res.data
                })
                    .catch(err => {
                        swal('', 'Algo ha sucedido', 'error')
                        console.log(err)
                    })
            return
        },
        
        getEnd(date){
            this.endErr = false
            
            if (this.init && moment(date).isBefore(moment(this.init))) {
                swal('', 'No puedes poner una fecha anterior de la de inicio, vuelva a seleccionarla')
                this.endErr = true
                this.init = ""
                return
            }
            this.end = moment(date).format('Y-MM-DD')
        },
        
        getInit(date){
            this.initErr = false
            
            if (this.end && moment(date).isAfter(moment(this.end))) {
                swal('', 'No puedes poner una fecha superior a la de fin, vuelva a seleccionarla')
                this.initErr = true
                return false
            }
            this.init = moment(date).format('Y-MM-DD')
        },

        verify () {
            console.log(this.initErr)
            if(this.initErr) {
                document.querySelector('#date_picker_init').value = ""
                this.init = ""
            }

            if(this.endErr) {
                document.querySelector('#date_picker_end').value = ""
                this.end = ""
            }
        }
    },
    mounted() {
        this.purchases.forEach(e => {
            e.code = e.payment_type == 3 ? e.transfer.number : e.transaction_code
        })

        this.dataTable = this.purchases
        setTimeout(() => {
            M.Datepicker.init(document.querySelector('#date_picker_init'), {
                format: "yyyy-mm-dd",
                onSelect: this.getInit,
                onClose: this.verify,
                i18n: pickDateI18n
            });
        }, 100);

        setTimeout(() => {
            M.Datepicker.init(document.querySelector('#date_picker_end'), {
                format: "yyyy-mm-dd",
                onSelect: this.getEnd,
                onClose: this.verify,
                i18n: pickDateI18n
            });


        }, 100);

        this.modal.init = M.Modal.init(document.querySelector('.modal'));
    }
}
</script>
