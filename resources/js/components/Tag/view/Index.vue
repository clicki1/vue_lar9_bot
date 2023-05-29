<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Категория</th>
            <th scope="col">Тэг</th>
            <th scope="col">Просмотр</th>
            <th scope="col">Изменить</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="tag in tags">
            <th scope="row">{{ tag.id }}</th>
            <td>{{tag.category}}</td>
            <td>{{tag.title}}</td>
            <td><router-link class="btn btn-outline-primary" :to="{ name:'tags.show', params: {id: tag.id}}">Show</router-link></td>
            <td><router-link class="btn btn-outline-success" :to="{ name:'tags.edit', params: {id: tag.id}}">Edit</router-link></td>
            <td><a class="btn btn-outline-danger" href="#" @click.prevent="deleteTag(tag.id)"> Delete</a></td>
        </tr>

        </tbody>
    </table>
</template>

<script>
export default {
    name: "TagsIndex",
    data() {
        return {
            tags: {},

        }
    },
    methods:{
        getTags() {
            axios.get('/api/vue/tags')
                .then(data => {
                    console.log(data.data);
                    this.tags = data.data.data})

        },
        deleteTag(id) {
            // console.log(id);
            axios.delete(`/api/vue/tags/${id}`)
                .then(res => {
                   // console.log(res.data);
                    this.getTags();
                });
        },
    },
    mounted() {
        this.getTags();
    }
}
</script>

<style scoped>

</style>
