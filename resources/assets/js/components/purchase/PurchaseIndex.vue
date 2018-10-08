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

                    <table-byte :set-table="dataTable" :filters="['name']">
                        <table-row slot="table-head" slot-scope="{ item }">
                            <table-head>Codigo de referencia</table-head>
                            <table-head>Cliente</table-head>
                            <table-head>Cambio</table-head>
                            <table-head>Acciones</table-head>
                        </table-row>

                        <table-row slot="table-row" slot-scope="{ item }">
                            <table-cell>{{ item.transaction_code }}</table-cell>
                            <table-cell>{{ item.user.name }}</table-cell>
                            <table-cell>{{ item.exchange.change }}</table-cell>
                            <!-- <table-cell>{{ item.transaction_code }}</table-cell> -->
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
                </section>
            </div>
        </div>
    </section>
</template>

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
            end: ''
        }
    },
    methods: {
        _refresh () {
            this.dataTable = this.purchases
            this.init = ''
            this.end = ''
        },
        _search () {
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
            this.end = moment(date).format('DD-MM-Y')
        },

        getInit(date){
            this.init = moment(date).format('DD-MM-Y')
        },
    },
    mounted() {
        this.dataTable = this.purchases
        setTimeout(() => {
            M.Datepicker.init(document.querySelector('#date_picker_init'), {
                format: "dd-mm-yyyy",
                onSelect: this.getInit,
                i18n: pickDateI18n
            });
        }, 100);

        setTimeout(() => {
            M.Datepicker.init(document.querySelector('#date_picker_end'), {
                format: "dd-mm-yyyy",
                onSelect: this.getEnd,
                i18n: pickDateI18n
            });
        }, 100);
    }
}
</script>
