<template id="template-collection-form">

    <section class="row">

        <div class="row">
            <div class="col s12">
                <a href="#!" class="btn btn-back" @click="$parent.options = 0">
                    <div class="btn-back__container">
                        <div class="btn-back__ico"></div>
                        <label>Volver</label>
                    </div>
                </a>
            </div>
        </div>

        <card-main class="row"> 
            <card-content>

                <form @submit.prevent="send" class="col s12">
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <input type="text" v-model="form.name">
                            <label for="">Nombre (Español)</label>
                        </div>

                        <div class="col s12 m6 input-field">
                            <input type="text" v-model="form.name_english">
                            <label for="">Nombre (Ingles)</label>
                        </div>

                        <div class="col s12 center-align">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>

            </card-content>
        </card-main>
    </section>
</template>

<script>
export default {
    template: "#template-collection-form",
    data () {
        return {
            form: {
                name: '',
                name_english: ''
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
            axios.post('admin/collections', this.form)
                .then(res => {
                    swal({
                        title: '',
                        text: 'Se registro la colección exitosamente',
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }, () => {
                        window.location = urlBase + "admin/collections";
                    })
                    
                })
                .catch(err => {
                    let message = "Disculpe, ha ocurrido un error";
                    if(err.response.status === 422){
                        message = err.response.data.error;
                    }
                    swal('', message, 'error');
                });
        },

        update (){
            this.form._method = "PUT";
            axios.post(`admin/collections/${this.form.id}`, this.form)
                .then(res => {
                    swal({
                        title: '',
                        text: 'Se edito la colección exitosamente',
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }, () => {
                        window.location = urlBase + "admin/collections";
                    })
                    
                })
                .catch(err => {
                    let message = "Disculpe, ha ocurrido un error";
                    if(err.response.status === 422){
                        message = err.response.data.error;
                    }
                    swal('', message, 'error');
                });
        }
    },

    mounted () {
        if(Object.entries(this.setForm).length > 0){
            this.form.name = this.setForm.name;
            this.form.name_english = this.setForm.name_english;
            this.form.id = this.setForm.id;
        }

        document.querySelectorAll('label').forEach(el => {
            el.classList.add('active');
        });
    }
}
</script>