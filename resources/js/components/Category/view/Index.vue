<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Категория</th>
            <th scope="col">Просмотр</th>
            <th scope="col">Изменить</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="category in categories">
            <th scope="row">{{ category.id }}</th>
            <td>{{category.title}}</td>
            <td><router-link class="btn btn-outline-primary" :to="{ name:'categories.show', params: {id: category.id}}">Show</router-link></td>
            <td><router-link class="btn btn-outline-success" :to="{ name:'categories.edit', params: {id: category.id}}">Edit</router-link></td>
            <td><a class="btn btn-outline-danger" href=""  @click.prevent="deleteCategory(category.id)"> Delete</a></td>
        </tr>

        </tbody>
    </table>
</template>

<script>
export default {
    name: "CategoriesIndex",
    data() {
        return {
            categories: {},

        }
    },
    methods:{
        getCategories() {
            axios.get('/api/vue/categories')
                .then(data => {
                    console.log(data.data);
                    this.categories = data.data.data})

        },
        deleteCategory(id) {
            // console.log(id);
            axios.delete(`/api/vue/categories/${id}`)
                .then(res => {
                   // console.log(res.data);
                    this.getCategories();
                });
        },
    },
    mounted() {
        this.getCategories();
    }
}
</script>

<style scoped>

</style>
