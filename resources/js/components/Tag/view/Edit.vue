<template>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Изменить тэг</th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <select class="form-select" aria-label="Default select example" v-model="category_id">
                                <template  v-for="cat in categories">
                                    <option
                                    :selected="cat.id === category_id" :value="cat.id"
                                    >
                                        {{ cat.title }}</option>
                                </template>
                            </select>
                            <input type="text" class="form-control" v-model="title" placeholder="введите название тэга">
                            <button type="submit" :disabled="isDisabled" class="btn btn-success"
                                    @click.prevent="update()"><i class="bi bi-send"></i> Добавить
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
    name: "TagsEdit",
    data() {
        return {
            id: null,
            title: null,
            category_id: null,
            categories: null,
            category: null,
        }
    },
    methods: {
        getCategories() {
            axios.get('/api/vue/categories')
                .then(data => {
                    console.log(data.data.data);
                    this.categories = data.data.data
                })

        },
        getTag() {
            axios.get(`/api/vue/tags/${this.$route.params.id}`)
                .then(data => {
                    console.log(data.data);
                    this.title = data.data.data.title,
                    this.category_id = data.data.data.category_id
                    this.id = data.data.data.id

                })

        },
        update() {
            axios.patch(`/api/vue/tags/${this.params}`, {'title': this.title, 'category_id': this.category_id, 'tag_id':this.id})
                .then(res => {
                    this.$router.push({name: "tags.show", params: {id: this.$route.params.id}})
                });
        }
    },
    mounted() {
        this.getTag();
        this.getCategories();
        // console.log(this.$route.params.id);
        // console.log(this.params);
    },
    computed: {
        params() {
            return this.$route.params.id;
        },
        isDisabled(){
            return !this.category_id && !this.title;
        }
    },
}
</script>

<style scoped>

</style>
