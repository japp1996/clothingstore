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
                            <label for="name" class="label-impegno">Descripción (Español)</label>
                            <textarea name="name" id="name" v-model="form.name" class="browser-default textarea-impegno"></textarea>
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="name_english" class="label-impegno">Descripción (Inglés)</label>
                            <textarea name="name_english" id="name_english" v-model="form.name_english" class="browser-default textarea-impegno"></textarea>
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <p class="bold">Precio Bs.</p>
                            <label for="name" class="label-impegno">Precio (Detal)</label>
                            <input type="text" name="price_1" id="price_1" v-model="form.price_1" class="browser-default input-impegno">
                            <label for="name" class="label-impegno">Precio (Mayor)</label>
                            <input type="text" name="price_2" id="price_2" v-model="form.price_2" class="browser-default input-impegno">
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <p class="bold">Precio USD</p>
                            <label for="name_english" class="label-impegno">Precio (Detal)</label>
                            <input type="text" name="price_usd_1" id="price_usd_1" v-model="form.price_usd_1" class="browser-default input-impegno">
                            <label for="name_english" class="label-impegno">Precio (Mayor)</label>
                            <input type="text" name="price_usd_2" id="price_usd_2" v-model="form.price_usd_2" class="browser-default input-impegno">
                        </div>

                        <div class="col s12 m6 l6 center-align">
                            <label for="" class="label-impegno">Categoría</label>
                            <select name="" id="" class="browser-default">
                                <option value="">Seleccione</option>
                                <option :value="item.id" :key="index" v-for="(item, index) in categories">{{ item.name }}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="" class="label-impegno">Subcategía</label>
                            <select name="" id="" class="browser-default">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="" class="label-impegno">Colección</label>
                            <select name="" id="" class="browser-default">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6 center-align">
                            <label for="" class="label-impegno">Diseños</label>
                            <select name="" id="" class="browser-default">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div id="test2" class="col s12">Test 2</div>
                <div id="test3" class="col s12">Test 3</div>
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
            form: {
                id: 0,
                name: "",
                name_english: "",
                description: "",
                description_english: "",
                price_1: "",
                price_2: "",
                price_usd_1: "",
                price_usd_2: "",
                category_id: "",
                subcategory_id: "",
                collection_id: "",
                design_id: ""
            },
            tabs: ""
        }
    },

    methods: {

    },

    mounted () {
        this.tabs = M.Tabs.init(document.querySelector(".tabs"))
    }
}
</script>

