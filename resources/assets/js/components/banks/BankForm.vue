<template>
    <div class="col s12">
        <div class="row">
            <div class="col s12">
                <a href="#!" class="btn btn-back" @click="$emit('back')">
                    <div class="btn-back__container">
                        <div class="btn-back__ico"></div>
                        <label for=""> Volver</label>
                    </div>
                </a>
            </div>
        </div>
         <div class="container-fluid">
            <div class="row container-form">
                <div class="col s12">
                    <form action="" @submit.prevent="_store">
                        <div class="col s6 center-align">
                            <label for="name" class="label-impegno">Nombre de la cuenta</label>
                            <input type="text" name="name" id="name" v-model="form.name" class="browser-default input-impegno">
                        </div>
                       <div class="col s6 center-align">
                            <label for="title" class="label-impegno">Banco</label>
                            <!-- <select name="" id="" v-model="form.bank_id" class="browser-default">
                                <option value="1">Corriente</option>
                                <option value="2">Ahorro</option>
                            </select> -->
                            <select name="" id="" v-model="form.bank_id">
                                <option :value="i" v-for="(c, i) in primaries" :key="i">{{ c.name }}</option>
                            </select>
                        </div>
                        <div class="col s6 center-align">
                            <label for="title" class="label-impegno">Número de cuenta</label>
                            <input type="number" name="title" id="title" v-model="form.number" class="browser-default input-impegno">                        
                        </div>
                        <div class="col s6 center-align">
                            <label for="title" class="label-impegno">Tipo de cuenta</label>
                            <select name="" id="" v-model="type" class="browser-default">
                                <option value="1">Corriente</option>
                                <option value="2">Ahorro</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .container-fluid{
        width: 90%;
        margin: auto;
    }
    .container-form{
        background-color: #fff;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding: 1rem .75rem;
    }
</style>


<script>
export default {
    data () {
        return {
            form: {
                name: '',
                bank_id: '',
                number: '',
                type: 1
            }
        }
    },
    methods: {
       _store () {

       }
    }
}
</script>
