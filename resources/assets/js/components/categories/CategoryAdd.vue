<template id="template-category-add">
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
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12 center-align">
                    <label for="name" class="label-impegno">Nombre de la categoría</label>
                    <input type="text" name="name" id="name" v-model="form.name" maxlength="50" class="browser-default input-impegno">
                </div>
                <div class="col s12 container-btn-add">
                    <button class="btn-add" @click="_addSubcategory()">
                        <img :src="'img/icons/new-msg.png' | asset" alt="" class="img-responsive">
                    </button>
                    <div class="btn-add-text">
                        Agregar Subcategoría
                    </div>
                </div>
                <div class="col s12 m6 l6 center-align" :key="index" v-for="(subcategory, index) in form.subcategories">
                    <label for="name" class="label-impegno">Subcategoría</label>
                    <input type="text" name="name" id="name" v-model="subcategory.name" maxlength="50" class="browser-default input-impegno">
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .container-btn-add{
        margin: 1rem 0;
    }
</style>

<script>
export default {
    template: "#template-category-add",

    props: {
        sizes: {
            type: Array,
            default () {
                return []
            }
        }
    },

    data () {
        return {
            form: {
                id: 0,
                name: "",
                sizes: [],
                subcategories: []
            }
        }
    },

    methods: {
        _back() {
            this.$emit('back', 0)
        },

        _addSubcategory() {
            this.form.subcategories.push({ name: "" })
        }
    }
}
</script>

