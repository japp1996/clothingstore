<template>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s4"><a class="active" href="#test1">Información</a></li>
                        <li class="tab col s4"><a href="#test2">Colores</a></li>
                        <li class="tab col s4"><a href="#test3">Imágenes</a></li>
                    </ul>
                </div>
                <div id="test1" class="col s12">
                    <div class="row container-form">
                        <div class="col s12">
                            <p><b>Nota:</b> El nombre (Español/Inglés) se irá construyendo con los campos que seleccionará a continuación.</p>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="category_id" class="label-impegno">Categoría</label>
                            <select name="category_id" id="category_id" class="browser-default" @change="_setSubcategories($event); _constructNames($event, 0, categories)" v-model="form.category_id">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in categories">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="subcategory_id" class="label-impegno">Subcategía</label>
                            <select name="subcategory_id" id="subcategory_id" class="browser-default" v-model="form.subcategory_id" @change="_constructNames($event, 1, subcategories)">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in subcategories">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="collection_id" class="label-impegno">Colección</label>
                            <select name="collection_id" id="collection_id" class="browser-default" v-model="form.collection_id" @change="_setDedings($event); _constructNames($event, 2, collections)">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in collections">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="design_id" class="label-impegno">Diseños</label>
                            <select name="design_id" id="design_id" class="browser-default" v-model="form.design_id" @change="_constructNames($event, 3, arrayDesigns)">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in arrayDesigns">{{ item.name }}</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="name" class="label-impegno">Nombre (Español)</label>
                            <!-- <input type="text" name="name" id="name" v-model="form.name" maxlength="50" class="browser-default input-impegno"> -->
                            <p class="names">{{ form.name }}</p>
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="name_english" class="label-impegno">Nombre (Inglés)</label>
                            <!-- <input type="text" name="name_english" id="name_english" v-model="form.name_english" maxlength="50" class="browser-default input-impegno"> -->
                            <p class="names">{{ form.name_english }}</p>
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="description" class="label-impegno">Descripción (Español)</label>
                            <textarea name="description" id="description" v-model="form.description" class="browser-default textarea-impegno"></textarea>
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="description_english" class="label-impegno">Descripción (Inglés)</label>
                            <textarea name="description_english" id="description_english" v-model="form.description_english" class="browser-default textarea-impegno"></textarea>
                        </div>
                        <div class="col s12 m6 l6 center-align container-options">
                            <label class="label-impegno">Moneda</label>
                            <p>
                                <label>
                                    <input name="group1" value="1" type="radio" v-model="form.coin" checked />
                                    <span>USD</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input name="group1" value="2" type="radio" v-model="form.coin" />
                                    <span>Bs. S</span>
                                </label>
                            </p>
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="name_english" class="label-impegno">Precio (Detal)</label>
                            <input type="text" name="price_1" id="price_1" v-model="form.price_1" class="browser-default input-impegno">
                            <label for="name_english" class="label-impegno">Precio (Mayor)</label>
                            <input type="text" name="price_2" id="price_2" v-model="form.price_2" class="browser-default input-impegno">
                        </div>

                        
                        <!-- <div class="col s12 m6 l6 center-align container-options">
                            <label class="label-impegno">Catálogo</label>
                            <p>
                                <label>
                                    <input name="catalogue" value="1" type="radio" v-model="form.catalogue" checked />
                                    <span>Dama</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input name="catalogue" value="2" type="radio" v-model="form.catalogue" />
                                    <span>Caballero</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input name="catalogue" value="3" type="radio" v-model="form.catalogue" />
                                    <span>Niños</span>
                                </label>
                            </p>                           
                        </div> -->
                        <div class="col s12 m6 l6 center-align container-options">
                            <label class="label-impegno">Tipo de venta</label>
                            <p>
                                <label>
                                    <input type="checkbox" id="retail" class="filled-in" checked="checked" value="1" v-model="form.retail" />
                                    <span>Detal</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="checkbox" id="wholesale" class="filled-in" value="1" v-model="form.wholesale" />
                                    <span>Mayor</span>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="test2" class="col s12">
                    <div class="row container-form">
                        <div class="col s12 container-btn-add">
                            <button class="btn-add" @click="_addColor()">
                                 <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                            </button>
                            <div class="btn-add-text">
                                Agregar nuevo
                            </div>                            
                        </div>
                        <div class="col s12" v-for="(item, index) in form.colors" :key="index">
                            <fieldset>
                                <button class="btn-remove" @click="_removeColor(index)">
                                    <img :src="'img/icons/cancelar_white.png' | asset" alt="" class="img-responsive">
                                </button>
                                <div class="row">
                                    <div class="col s12 m6 l6 center-align">
                                        <label for="name" class="label-impegno">Nombre (Español)</label>
                                        <input type="text" name="name" id="name" v-model="item.name" maxlength="50" class="browser-default input-impegno">
                                    </div>
                                    <div class="col s12 m6 l6 center-align">
                                        <label for="name_english" class="label-impegno">Nombre (Inglés)</label>
                                        <input type="text" name="name_english" id="name_english" v-model="item.name_english" maxlength="50" class="browser-default input-impegno">
                                    </div>
                                    <div class="col s12">
                                        <fieldset class="sizes_stop">
                                            <legend>Inventario por tallas</legend>
                                            <div class="col s6 m3 l3 center-align" v-for="(size, z) in item.sizes" :key="z">
                                                <label class="label-impegno">{{ size.name }}</label>
                                                <input type="number" min="0" v-model="item.sizes[z].amount" class="browser-default input-impegno">
                                            </div>
                                        </fieldset>
                                    </div>                                                                        
                                </div>                                
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div id="test3" class="col s12">
                    <div class="row container-form">
                        <div class="row">
                            <div class="col s12 center-align">
                                <label for="" class="label-impegno">Imagen Principal</label>
                                <input-file :file="`img/products/${form.main}` | img" :btn="false" :image="true" @file="_setFile(null, null, $event)"></input-file>
                            </div>
                        </div>
                        <div class="row gallery__items">
                            <div class="col s12 container-btn-add">
                                <button class="btn-add" @click="_addImage()">
                                    <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                                </button>
                                <div class="btn-add-text">
                                    Agregar nueva imagen secundaria
                                </div>                            
                            </div>
                            <div class="col l4 m6 s6 items__file" :key="index" v-for="(file, index) in form.images" :id="`file-${file.id}`">
                                <input-file :file="file.file !== '' ? `${urlBase + 'img/products/' + file.file}` : ''" :btn="false" :image="true" @file="_setFile(file.id, index, $event)"></input-file>
                                <button class="file__claer" @click="_sliceItem(file.id, index)"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l12 margin-top center-align">
                <a href="#!" class="btn btn-success" @click="_edit($event)">Actualizar</a>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .bold{
        font-weight: bold;
    }
    .margin-top{
        margin-top: 20px;
    }
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
    .container-options{
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        label{
            flex: 1 1 100%;
        }
    }
    fieldset{
        margin: 10px 2px !important;
        border: 1px solid #efefefec !important;
        padding: 1rem !important;
        position: relative;
    }
    .label-impegno{
        font-weight: bold;
    }
    .items__file{
        position: relative;
    }
    .names{
        margin-bottom: 1rem;
    }
    .sizes_stop{
        margin: .5rem .2rem !important;
        border-color: rgba($color: #000000, $alpha: .3);
        border-radius: .4rem;
        legend{
            font-weight: bold;
            padding: 0 10px;
        }
    }
</style>

<script>
export default {
    props: {
        categories: {
            type: Array,
            default: []
        },

        designs: {
            type: Array,
            default: []
        },

        collections: {
            type: Array,
            default: []
        },

        data: {
            type: Object,
            default: {}
        }
    },

    data () {
        return {
            urlBase: urlBase,
            tabs: "",
            form: {
                main: {
                    file: ""
                },
                images: [],
                colors: [],
                colors_delete: []
            },
            subcategories: [],
            arrayDesigns: [],
            selectedCategory: {},
            objectNames: {
                spanish: [],
                english: []
            },
            inserted: [],
            images: [],
            image: "",
            ids: 0,
            elements: 0
        }
    },

    created() {
        this.form = this.data;
        this.form.colors_delete = [];

        this.urlBase = urlBase     
    },

    methods: {
        _back() {
            this.$emit('back', 0)
        },

        _setSubcategories(e, el = null) {            
            let val = el != null ? el.value : e.target.options[e.target.selectedIndex].value
            if (val == "") {
                this.subcategories = []
            }else {
                this.selectedCategory = this.categories.find((el) => {
                    return (el.id == val)
                })            
                this.subcategories = this.selectedCategory.subcategories
            }  
        },

        _setDedings(e, el = null) {
            let val = el != null ? el.value : e.target.options[e.target.selectedIndex].value          
            if (val == "") {
                this.arrayDesigns = []
            }else {
                this.arrayDesigns = this.designs.filter((el) => {                    
                    return (el.collection_id == val)
                })
            }
        },

        _addColor() {
            if (Object.keys(this.selectedCategory) == 0) {
                this._showAlert("Disculpa, debes seleccionar una categoría primero.", "warning")
                return false
            }
            let sizes = []
            this.selectedCategory.sizes.forEach(element => {
                sizes.push({id: element.id, name: element.name, amount_id: 0})
            });
            this.form.colors.push({id: 0, name: "", sizes: sizes})
                    
        },

        _removeColor(i) {
            let color_delete = this.form.colors.splice(i, 1);
            this.form.colors_delete.push(color_delete[0]);
        },

        _setFile(i, x, e) {
            // let progressElement = document.querySelector(`#progress-${x}`)
            // progressElement.classList.add('progress-active')
            let formData = new FormData()
            formData.append('id',  i)
            formData.append('file', e.file)
            formData.append('product_id', this.form.id)
            axios.post('admin/update-images', formData)
            .then(resp => {
                if (i != null) {
                    this.form.images[x].id = resp.data.id
                    this.form.images[x].file = resp.data.file
                }
            })
            .catch(err => {
                this._showAlert("Disculpa, ha ocurrido un error", "error")
            })
        },

        _sliceItem (id, i) {
            let parent = document.querySelector(".gallery__items")
            let child = document.querySelector(`#file-${id}`)            
            
            if (id != 0) {
                axios.post('admin/delete-images', {id: id})
                .then(resp => {
                    parent.removeChild(child)
                    this.elements = this.elements - 1
                })
                .catch(err => {
                    this._showAlert("Disculpa, ha ocurrido un error", "error")
                })
            } else {
                parent.removeChild(child)
                this.elements = this.elements - 1
            }
        },

        _constructNames(e, i, item) {
            let value = e.target.options[e.target.selectedIndex].value
            if (value != "") {
                let selected = item.find((el) => {
                    return(el.id == value)
                })
                if (this.inserted.indexOf(i) > -1) {
                    this.objectNames.spanish.splice(i, 1);
                    this.objectNames.english.splice(i, 1);
                    if (i == 0 || (i % 2 == 0)) {
                        this.objectNames.spanish.splice(i, 1);
                        this.objectNames.english.splice(i, 1);
                        this.inserted.splice(i + 1, 1);
                    }
                } else {
                    this.inserted.splice(i, 0, i);
                }
                this.objectNames.spanish.splice(i, 0, selected.name);
                this.objectNames.english.splice(i, 0, selected.name_english);
                this.form.name = ""
                this.form.name_english = ""
                this.objectNames.spanish.forEach((el, i) => {
                    if ((this.objectNames.spanish.length -1) == i) {
                        this.form.name += el
                    } else {
                        this.form.name += el + ' - '
                    }
                })
                this.objectNames.english.forEach((el, i) => {
                    if ((this.objectNames.english.length -1) == i) {
                        this.form.name_english += el
                    } else {
                        this.form.name_english += el + ' - '
                    }
                })      
            } else {

            }
        },

        _addImage() {
            // this.ids = this.form.images.length > 1 ? this.ids + 1 : this.ids
            this.form.images.push({file: "", id: 0})
            this.images = this.form.images
            this.elements = this.elements + 1
        },

        _edit (e) {
            let button = e.target
            this.form.wholesale = this.form.wholesale == false ? 0 : 1
            this.form.retail = this.form.wholesale == false ? 0 : 1

            if (this.form.wholesale == 0 && this.form.retail == 0) {
                this._showAlert("Debes seleccionar al menos un tipo de venta", "warning")
                return false;
            }
            if (this.form.colors.length == 0) {
                this._showAlert("Debes cargar al menos color y existencia del mismo", "warning")
                return false;
            }           
            for (let x = 0; x < this.form.colors.length; x++) {
                if (this.form.colors[x].name == "" || this.form.colors[x].name_english == "") {
                    this._showAlert("Debes completar los campos referentes a los colores del producto", "warning")
                    return false
                }                
                for (let y = 0; y < this.form.colors[x].sizes.length; y++) {
                    if (typeof this.form.colors[x].sizes[y].amount == 'undefined') {
                        this._showAlert("Debes completar los campos referentes a los colores del producto", "warning")
                        return false
                    }               
                }                
            }
            button.setAttribute('disabled', true)
            axios.post(`admin/products/${this.form.id}`, this._convertToFormData())
            .then(resp => {                
                if (resp.data.result) {
                    swal({
                        title: '',
                        text: 'Producto editado exitosamente',
                        timer: 2000,
                        showConfirmButton: false,
                        type: "success"
                    }, () => {
                        location.reload();
                    })
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
            formData.append('_method', 'PATCH');
            Object.getOwnPropertyNames(this.form).forEach((key, i) => {
                let count = 0;
                if(key === "images")
                {
                    // this.images.forEach((e, y) => {
                    //     if (e.file !== "") {
                    //         count = count + 1
                    //         formData.append(`file${count}`, e.file);
                    //     }                        
                    // })
                    // formData.append('count', count)
                }else if(key != "__ob__"){
                    if (key == 'colors') {
                        formData.append(key, JSON.stringify(this.form[key]));
                    }else if(key == 'colors_delete'){
                        formData.append(key, JSON.stringify(this.form[key]));
                    }else {
                        formData.append(key, this.form[key]);
                    }                    
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

    mounted () {
        this.tabs = M.Tabs.init(document.querySelector(".tabs"))
        this._setSubcategories(null, document.querySelector('#category_id'))
        this._setDedings(null, document.querySelector("#collection_id"))
        // Set images
        let images = new Array()
        this.form.images.forEach(el => {            
            if (el.main == "1") {
                this.form.main = el.file                
            } else {
                images.push(el)
            }
        })
        this.form.images = images
        // Set Colors
        
        // let MainColors = this.form.colors
        let colors = new Array()
        let sizesArray= new Array()        
        this.form.colors.forEach(el => { 
            sizesArray = []          
            el.amounts.forEach(s => {                
                sizesArray.push({id: s.category_size.id, name: s.category_size.size.name, amount: s.amount, amount_id: s.amount_id})
            })
            colors.push({id: el.id, name: el.name, name_english: el.name_english, sizes: sizesArray})
        })
        this.form.colors = colors
    }
}
</script>
