<template id="template-allies-add">
    <div class="col s12">
        <div class="row">
            <div class="col s12">
                <a href="#!" class="btn btn-back" @click="_back()">
                    <div class="btn-back__container">
                        <div class="btn-back__ico"></div>
                        <label for=""> Volver</label>
                </div>
                </a>
            </div>
        </div>
        <card-main>
            <card-content>
                <div class="row">
                    <div class="col s12 m6 l6 center-align">
                        <label for="nombre" class="label-impegno">Nombre (Español)</label>
                        <input type="text" name="nombre" id="nombre" v-model="form.nombre" class="browser-default input-impegno">
                    </div>
                    <div class="col s12 m6 l6 center-align">
                        <label for="facebook" class="label-impegno">Facebook</label>
                        <input type="text" name="facebook" id="facebook" v-model="form.facebook" class="browser-default input-impegno">
                    </div>
                    <div class="col s12 m6 l6 center-align">
                        <label for="twitter" class="label-impegno">Twitter</label>
                        <input type="text" name="twitter" id="twitter" v-model="form.twitter" class="browser-default input-impegno">
                    </div>
                    <div class="col s12 m6 l6 center-align">
                        <label for="instagram" class="label-impegno">Instagram</label>
                        <input type="text" name="instagram" id="instagram" v-model="form.instagram" class="browser-default input-impegno">
                    </div>
                    <div class="col s12 m6 l6 center-align">
                        <label for="direccion" class="label-impegno">Dirección</label>
                        <textarea name="direccion" id="direccion" v-model="form.direccion" class="browser-default input-impegno"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="row gallery__items">
                        <div class="col s12 container-btn-add">
                            <button class="btn-add" @click="_addItem()">
                                <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                            </button>
                            <div class="btn-add-text">
                                Agregar imagen
                            </div>                            
                        </div>
                        <div class="col l4 m6 s6 items__file" :key="index" v-for="(file, index) in form.files" :id="`file-${file.id}`">
                            <input-file :btn="false" :image="true" v-on:file="_setFile(index, $event)"></input-file>
                            <button class="file__claer" @click="_sliceItem(file.id, index)"></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center-align">
                        <a href="#!" class="btn btn-success" @click="_store($event)">Guardar</a>
                    </div>                    
                </div> 
            </card-content>
        </card-main>
    </div>
</template>

<style lang="scss">
    textarea{
        resize: none; 
        height: 10rem !important;
    }
    .items__file{
        position: relative;
    }
</style>

<script>
export default {
    template: "#template-allies-add",

    props: {

    },

    created() {

    },

    data () {
        return {
            form: {
                nombre: "",
                facebook: "",
                twitter: "",
                instagram: "",
                direccion: "",
                files: [{file: "", id: 0}]
            },
            files: [],
            ids: 0
        }
    },

    methods: {
        _back() {
            this.$emit('back', 0)
        },

        _addItem() {
            this.ids = this.form.files.length > 1 ? this.ids + 1 : this.ids
            this.form.files.push({file: "", id: this.ids})
            this.files = this.form.files         
        },

        _setFile (i, file) {
            this.form.files[i].file = file.file
            this.files = this.form.files
        },

        _sliceItem (id, i) {            
           this.files = this.form.files.filter((el) => {
                return (el.id != id)
            })
            let parent = document.querySelector(".gallery__items")
            let child = document.querySelector(`#file-${id}`)            
            parent.removeChild(child)
        },

        _store (e) {
            let button = e.target
            if (this.files.length == 0) {
                this._showAlert("Disculpa debes cargar al menos una archivo", "warning")
                return false   
            }
            button.setAttribute('disabled', true)
            axios.post('admin/allies', this._convertToFormData())
            .then(resp => {                
                if (resp.data.result) {
                    this._showAlert("Aliado almacenado exitosamente", "success")
                    setTimeout(() => {
                        window.location.reload()
                    }, 3000);
                }
            })
            .catch(err => {
                if(err.response.status === 422){
                    this._showAlert(err.response.data.error, 'warning')
                    return false;
                }
                
                this._showAlert("Disculpa, ha ocurrido un error", "error")
            })
            .then(all => {
                button.removeAttribute('disabled')
            })
        },

        _convertToFormData(){
            let formData = new FormData();
            Object.getOwnPropertyNames(this.form).forEach((key, i) => {
                let count = 0;
                if(key === "files")
                {
                    this.files.forEach((e, y) => {
                        if (e.file !== "") {
                            count = count + card
                            formData.append(`file${count}`, e.file);
                        }                        
                    })
                    formData.append('count', count)
                }else if(key != "__ob__"){
                    formData.append(key, this.form[key]);
                }
            });

            return formData;
        },

        _showAlert(text, type) {
            swal({
                title: "",
                text: text,
                timer: 3000,
                showConfirmButton: false,
                type: type
            })
        },
    },

    mounted() {
        this.ids = this.form.files.length
    }
}
</script>

