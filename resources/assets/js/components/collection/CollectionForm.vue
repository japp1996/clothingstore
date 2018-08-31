<template>
    <section class="row">
        <div class="col s12">
            <card-main> 
                <card-content>
                    <card-title>
                        <h1>Perfil</h1>
                    </card-title>
                    <div class="row">

                        <div class="col s6 input-field">
                            <input type="text" v-model="form.name">
                            <label for="">Nombre</label>
                        </div>

                        <div class="col s6 input-field">
                            <input type="text" v-model="form.username">
                            <label for="">Usuario</label>
                        </div>

                        <div class="col s6 input-field">
                            <input type="password" v-model="form.password">
                            <label for="">Contraseña</label>
                        </div>

                        <div class="col s6 input-field">
                            <input type="password" v-model="form.password_confirmation">
                            <label for="">Confirmar Contraseña</label>
                        </div>

                        <div class="col s12 center-align">
                            <button @click="store" class="btn btn-success" :disabled="passwordError">Actualizar perfil</button>
                        </div>

                    </div>
                </card-content>
            </card-main>
        </div>
    </section>
</template>

<style>
    .err {
        color: #F44336 !important;
    }
</style>


<script>
export default {
    data () {
        return {
            form: {
                name: '',
                surname: '',
                password: '',
                password_confirmation: ''
            },
            errors: {
                password: '',
                password_confirmation: ''
            }
        }
    },
    props: {
        user: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    watch: {
        form: {
            handler (form) {
                if(form.password && !form.password_confirmation) {
                    this.errors.password_confirmation = 'Debe confirmar la contraseña nueva'
                    return
                }else {
                    this.errors.password_confirmation = ''
                }

                if(form.password || form.password_confirmation) { // Si alguno de los dos tiene datos
                    if(form.password != form.password_confirmation) {
                        this.errors.password = 'Las contarseñas no coinciden'
                    }else {
                        this.errors.password = ''
                    }
                }
            },
            deep: true
        }
    },
    computed: {
        passwordError () {
            let changingPassword = this.form.password != '' || this.form.password_confirmation != ''
            let errorPassword = this.errors.password != '' || this.errors.password_confirmation !=''

            return changingPassword && errorPassword
        },
    },
    methods: {
        store () {
            axios.post('admin/perfil', this.form)
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
                    console.log(err)
                })
        }
    },
    mounted () {
        this.form.name = this.user.name;
        this.form.username = this.user.username;
    }
}
</script>