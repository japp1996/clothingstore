<template id="template-table">
    <div class="row">
        <div class="col s12 m4 offset-m8 input-field input-search-table" v-show="filters.length > 0">
            <i class="material-icons prefix">search</i>
            <input type="text" @keyup="_filter" v-model="filter">
        </div>
        <table class="bordered highlight responsive-table table-impegno">
            <thead>
                <slot name="table-head"></slot>
                <tr v-if="thead.length > 0">
                    <th v-for="(th, index) in thead" :key="`th-` + index">{{ th.name }}</th>
                </tr>
            </thead>
            <tbody>
                <slot name="table-row" v-for="(row, i) in bodyTableRender" :item="row" :index="i"></slot>
                <slot name="empty-rows" v-if="rows.length === 0"></slot>
            </tbody>
            <tfoot>
                <slot name="table-foot"></slot>
            </tfoot>
        </table>
        
         <!-- Paginador -->
        <div class="col s12 center-align" v-show="pages.length > 1">
            <ul class="pagination">
                <!-- <li :class="currentPage==1?'hidden_li':''" v-on:click="currentPage = currentPage-1">   
                    <a href="#!"><i class="mdi-navigation-chevron-left"></i></a>
                </li> -->

                <li v-for="(pag, pages_index) in pages" :class="currentPage==pag?'active':''" 
                v-on:click="changePage(pag)" 
                :key="'li-pag' + pages_index"> <a href="#!">{{pag}} </a></li>
                
                <!-- <li :class="currentPage==lastPage || pages.length == 1?'hidden_li':''" v-on:click="currentPage = currentPage+1"><a href="#!">
                    <i class="mdi-navigation-chevron-right"></i></a>
                </li> -->
            </ul>
        </div>

        <!-- <div class="col s12 m6 offset-m3" v-if="rows.length !== 0">
            <ul class="pagination">
                <li :class="pagination.first_page.class">
                    <a :href="pagination.first_page.path"><i class="material-icons">chevron_left</i></a>
                </li>

                <li v-for="num in pagination.pages" :key="'pag-' + num" :class="pagination.current_page == num ? 'active' : 'waves-effect'">
                    <a :href="`${pagination.path}?page=${num}`">{{ num }}</a>
                </li>

                <li :class="pagination.last_page.class">
                    <a :href="pagination.last_page.path"><i class="material-icons">chevron_right</i></a>
                </li>
            </ul>
        </div> -->
    </div>
</template>

<style>
    .pagination {
        text-align: center;
    }

    table .btn-floating i{
        color: #fff;
    }
</style>

<script>
export default {
    template: "#template-table",
    props: {
        forPage:{
            type:Number,
            default: 10
        },
        'set-table': {
            type: Array,
            default(){
                return [];
            }
        },
        id: {
            type: String,
            default: "table-byte-" + Math.floor(Math.random() * (1000 - 1)) + 1
        },
        filters: {
            type: Array,
            default() {
                return []
            }
        },
        'external-filter': {
            type: String
        }
    },
    data() {
        return {
            rows: [],
            thead: [],
            filter: '',
            pagination: {
                first_page: '',
                last_page: ''
            },
            currentPage:1,      // Pagina por defecto
            lastPage:'',        // Última página
            pagesArray:[],      // Array que contendra las paginas a mostrar
            itemsTotal:[],       // Array que contendra los datos
            tempTable: []
        }
    },
    watch: {
        externalFilter(value){
            let result = []
            let alls = this.setTable;
            this.filter = value;

            this.filters.forEach((f, k) => {
                let flag = false
                if(f.indexOf('.') > -1) { // Busco puntos en el filtro, para saber que se trata de una busquede de un objeto
                    let propieties = f.split('.');

                        alls.forEach(r => {
                        
                            let value = ''
                            for(let i = 0; i < propieties.length; i++) {
                                if(value == '') {
                                    value = r[propieties[i]]
                                }else {

                                    if(i == propieties.length-1) {
                                        if(value[propieties[i]].toString().toLowerCase().indexOf(this.externalFilter.toString().toLowerCase()) >= 0){
                                            if(!result.includes(r)) {
                                                result.push(r);
                                            }
                                        }
                                    }else {
                                        value = value[propieties[i]]
                                    }
                                }  
                            }

                        })
                }else {
                    alls.forEach(r => {
                        if(r[f].toString().toLowerCase().indexOf(this.externalFilter.toString().toLowerCase()) >= 0){
                            if(!result.includes(r)) {
                                result.push(r);
                            }
                        }
                    })
                }
            });

            this.rows = result;
        }
    },
    computed: {
       

        /**
         * Muestro la pagina actual
         */
        isActive (val) {
            if(val == this.currentPage){
                return true;
            }
        },

        /**
         * Muestro la cantidad de paginas posibles
         */
        pages () {
            this.pagesArray= [];
            let totalItems = this.rows.length;
            if(totalItems == 0){
                this.pagesArray.push(1)
                return this.pagesArray;
            }else{
                this.pagesArray= [];
                this.lastPage = (Math.ceil(totalItems/this.forPage));

                if(this.lastPage==0){
                    this.pagesArray.push(1)
                }else{
                    for (let index = 1; index <= this.lastPage; index++) {
                        this.pagesArray.push(index)
                    }
                }
            }
            return this.pagesArray;
        },

        /**
         * Muestro la cantidad de registros por paginas
         */
        bodyTableRender (){
            if(this.filter==''){
                this.rows = this.setTable; 
            }

            if(this.currentPage==1){

                return this.rows.slice(0,this.forPage)

            }else{

                if(this.filter != '' && this.currentPage > this.lastPage) {
                    this.currentPage = 1
                }

                let since = parseInt(parseInt(this.currentPage)*parseInt(this.forPage))-this.forPage;
                let until = parseInt(parseInt(this.currentPage)*parseInt(this.forPage));
                return this.rows.slice(since,until)
            
            }
        }
    },
    methods: {
         /**
         * Función que realiza el cambio de página
         */
        changePage:function(page){
            this.currentPage = page;
        },
        _setPagination(object){

            this.pagination = {
                pages: object.last_page,
                first_page: {
                    class: object.current_page == 1 ? 'disabled' : 'waves-effect',
                    path: object.current_page == 1 ? '#!' : `${object.path}?page=${object.first_page}`,
                },
                last_page: {
                    class: object.current_page == object.last_page ? 'disabled' : 'waves-effect',
                    path: object.current_page == object.last_page ? '#!' : `${object.path}?page=${object.last_page}`
                },
                path: object.path,
                current_page: object.current_page
            }

        },
        _filter () {
            let result = []
            let alls = this.setTable 

            this.filters.forEach((f, k) => {
                let flag = false
                if(f.indexOf('.') > -1) { // Busco puntos en el filtro, para saber que se trata de una busquede de un objeto
                    let propieties = f.split('.');

                        alls.forEach(r => {
                        
                            let value = ''
                            for(let i = 0; i < propieties.length; i++) {
                                if(value == '') {
                                    value = r[propieties[i]]
                                }else {

                                    if(i == propieties.length-1) {
                                        if(value[propieties[i]].toString().toLowerCase().indexOf(this.filter.toLowerCase()) >= 0){
                                            if(!result.includes(r)) {
                                                result.push(r);
                                            }
                                        }
                                    }else {
                                        value = value[propieties[i]]
                                    }
                                }  
                            }

                        })
                }else {
                    alls.forEach(r => {
                        if(r[f].toString().toLowerCase().indexOf(this.filter.toLowerCase()) >= 0){
                            if(!result.includes(r)) {
                                result.push(r);
                            }
                        }
                    })
                }
            })

            this.rows = result;
        },
        /**
         *  Método para setear la posicion del objeto dentro del array
         */
        setPos:function(since, until){
            for (let index = since; index <= until; index++) {
                if(this.itemsTotal[index] != undefined){
                    this.itemsTotal[index].positionJson = index;
                }
            }
        }
    },
    mounted(){
        this.tempTable = this.setTable
        this.rows = this.setTable
        // this._setPagination(this.setTable);
    }
}
</script>

