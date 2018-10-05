<template id="template-wholesaler-index">
    <section class="container-fluid">
        <div class="row">
            <div class="col m8 offset-m2">
                <div class="row">
                    <div class="col s12 center-align">
                        <h1>Crear Colección Mayorista</h1>
                    </div>
                </div>

                
            </div>
        </div>
    </section>
</template>

<style>
 .container-form{
        background-color: #fff;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding: 1rem .75rem;
    }
</style>


<script>
import { mapState } from 'vuex'

export default {
    props: {
        wholesaler: {
            type: Object,
            default: {}
        }
    },
    data () {
        return {
            form: {
                filter_id: '',
                name: null,
                name_english: null,
                quantity: null,
                coin: '1',
                price: null,
                description: null,
                description_english: null,
                images: [],
                main: ""
            },
            images: [],
            image: "",
            ids: 0,
            filters: [],
        }
    },
    computed: mapState({
        option: state => state.wholesalers.option
    }),
    methods: {
        addImage () {
            this.ids = this.form.images.length > 1 ? this.ids + 1 : this.ids
            this.form.images.push({file: "", id: this.ids})
            this.images = this.form.images
        },

        quitImage (id, i) {            
            this.images = this.form.images.filter((el) => {
                return (el.id != id)
            })
            let parent = document.querySelector(".gallery__items")
            let child = document.querySelector(`#file-${id}`)            
            parent.removeChild(child)
        },
        setImage(i, file) {
            if (i == null) {
                this.image = file.file
                this.form.main = file.file
            }else {
                this.form.images[i].file = file.file
                this.files = this.form.images
            }            
        },
        setOption (option) {
            this.$store.dispatch('wholesalers/changeOption', option)
        },
        getFilters () {
            axios.get('admin/filters/get')
                .then(res => {
                    this.filters = res.data
                })
                .catch(err => {
                    console.log(err)
                }) 
        },
        update () {
               
        },
        cleanForm() {
            Object.getOwnPropertyNames(this.form).forEach((key, i) => {
                if(key === "images") {
                    this.images = []
                    this.image = ''
                    this.form.images = []
                }else {
                    if(key != "__ob__"){ 
                        formData.append(key, this.form[key]);   
                    }      
                }
            })
        },
        convertToFormData(){
            let formData = new FormData();
            Object.getOwnPropertyNames(this.form).forEach((key, i) => {
                let count = 0;
                if(key === "images")
                {
                    this.images.forEach((e, y) => {
                        if (e.file !== "") {
                            count = count + 1
                            formData.append(`file${count}`, e.file);
                        }                        
                    })
                    formData.append('count', count)
                }else if(key != "__ob__"){
                    formData.append(key, this.form[key]);                       
                }
            });

            return formData;
        }
    },
    mounted () {
        this.getFilters()
        
        Object.getOwnPropertyNames(this.wholesaler).forEach((key, i) => {
            let count = 0;
            if(key === "images") {
                this.images.forEach((e, y) => {
                    if (e.file !== "") {
                        count = count + 1
                        formData.append(`file${count}`, e.file);
                    }                        
                })
                formData.append('count', count)
            }else if(key != "__ob__"){
                formData.append(key, this.form[key]);                       
            }
        });

        
    }
}
</script>
