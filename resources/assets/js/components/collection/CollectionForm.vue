<template id="template-collection-form">
    <section class="row">

            <card-main class="col s12"> 
                <card-content>
                    <card-title>
                        <h1>Perfil</h1>
                    </card-title>

                    <a href="#!" @click="$parent.options = 0">Volver</a>

                    <form @submit.prevent="send" class="row">

                        <div class="col s12 m6 input-field">
                            <input type="text" v-model="form.spanish">
                            <label for="">Nombre (Español)</label>
                        </div>

                        <div class="col s12 m6 input-field">
                            <input type="text" v-model="form.english">
                            <label for="">Nombre (Ingles)</label>
                        </div>

                        <div class="col s12 center-align">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                    
                </card-content>
            </card-main>
        
    </section>
</template>

<script>
export default {
    template: "#collection-form",
    data () {
        return {
            form: {
                spanish: '',
                english: ''
            }
        }
    },
    props: {
        'set-form': {
            type: Object,
            default () {
                return {}
            }
        }
    },
    methods: {
        send () {
            if(this.form.id == undefined){
                this.store()
            }else{
                this.update();
            }
        },

        store (){
            axios.post('admin/collection', this.form)
                .then(res => {
                    swal('', 'Se registro la colección exitosamente', 'success')
                })
                .catch(err => {
                    if(err.response.status === 422){
                        swal("", err.response.data.error, "error");
                        return
                    }

                    swal({
                        title: "",
                        text: `Algo ha ocurrido`,
                        timer: 2000,
                        showConfirmButton: false,
                        type: "error"
                    });
                });
        },

        update (){
            this.form._method = "PUT";
            axios.post('admin/collection', this.form)
                .then(res => {
                    swal('', 'Se actualizó el perfil correctamente', 'success')
                })
                .catch(err => {
                    if(err.response.status === 422){
                        swal("", err.response.data.error, "error");
                        return
                    }

                    swal({
                        title: "",
                        text: `Algo ha ocurrido`,
                        timer: 2000,
                        showConfirmButton: false,
                        type: "error"
                    });
                });
        }
    },
    mounted () {
        
    }
}
</script>