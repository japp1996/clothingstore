<template id="template-product-form">
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
                        <div class="col s12 m6 l6 center-align">
                            <label for="name" class="label-impegno">Nombre (Español)</label>
                            <input type="text" name="name" id="name" v-model="form.name" maxlength="50" class="browser-default input-impegno">
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="name_english" class="label-impegno">Nombre (Inglés)</label>
                            <input type="text" name="name_english" id="name_english" v-model="form.name_english" maxlength="50" class="browser-default input-impegno">
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

                        <div class="col s12 m6 l6 center-align">
                            <label for="category_id" class="label-impegno">Categoría</label>
                            <select name="category_id" id="category_id" class="browser-default" @change="_setSubcategories($event)" v-model="form.category_id">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in categories">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="subcategory_id" class="label-impegno">Subcategía</label>
                            <select name="subcategory_id" id="subcategory_id" class="browser-default" v-model="form.subcategory_id">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in subcategories">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="collection_id" class="label-impegno">Colección</label>
                            <select name="collection_id" id="collection_id" class="browser-default" v-model="form.collection_id">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in collections">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="design_id" class="label-impegno">Diseños</label>
                            <select name="design_id" id="design_id" class="browser-default" v-model="form.design_id">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in designs">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m12 l12">
                            <div class="col s12 m6 l6 center-align container-options">
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
                            </div>                            
                        </div>
                    </div>
                </div>
                <div id="test2" class="col s12">
                    <div class="row container-form"></div>
                </div>
                <div id="test3" class="col s12">
                    <div class="row container-form"></div>
                </div>
            </div>

            <div class="col s12 m12 l12 margin-top center-align">
                <a href="#!" class="btn btn-success" @click="_store($event)" v-if="action == 0">Guardar</a>
                <a href="#!" class="btn btn-success" @click="_edit($event)" v-else>Actualizar</a>
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
</style>

<script>
export default {
    template: "#template-product-form",

    props: {
        action: {
            type: Number,
            default: 0
        },

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
    },

    created () {

    },

    data () {
        return {
            subcategories: [],
            selectedCategory: {},
            form: {
                id: 0,
                name: "",
                name_english: "",
                description: "",
                description_english: "",
                coin: "1",
                price_1: "",
                price_2: "",
                catalogue: "1",
                category_id: "",
                subcategory_id: "",
                collection_id: "",
                design_id: "",
                retail: "1",
                wholesale: "1",
                colors: [],
                images: []
            },
            tabs: "",
            images: ""
        }
    },

    methods: {
        _back() {
            this.$emit('back', 0)
        },

        _setSubcategories(e) {            
            this.selectedCategory = this.categories.find((el) => {
                return (el.id == e.target.options[e.target.selectedIndex].value)
            })            
            this.subcategories = this.selectedCategory.subcategories
        },
    },

    mounted () {
        this.tabs = M.Tabs.init(document.querySelector(".tabs"))
    }
}
</script>

