<template>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Добавить тег</th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <select class="form-select" aria-label="Default select example" v-model="category_id">
                                <option selected value="null">Выберите категорию</option>
                                <template  v-for="cat in categories">
                                        <option :value="cat.id">{{ cat.title }}</option>
                                </template>
                            </select>
                            <input type="text" class="form-control" v-model="title" placeholder="введите название тэга">
                            <button type="submit" :disabled="isDisabled" class="btn btn-success"
                                    @click.prevent="store()"><i class="bi bi-send"></i> Добавить
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</template>

<script>

export default {
    data() {
        return {

            title: null,
            category_id: null,
            categories: null
        }
    },
    name: "TagCreate",

    methods: {
        store() {

            axios.post('/api/vue/tags', {'title': this.title, 'category_id': this.category_id})
                .then(res => {
                    this.$router.push({name: "tags.index"})
                })
        },
        getCategories() {
            axios.get('/api/vue/categories')
                .then(data => {
                    console.log(data.data.data);
                    this.categories = data.data.data
                })

        },


    },
    mounted() {
        this.getCategories();
    },
    computed: {
        isDisabled() {
            return !this.title ;
        }
    }
}
</script>

<style scoped>

</style>
