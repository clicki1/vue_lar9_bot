<template>
    <table class="table"  v-if="tag">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Сообщение</th>
            <th scope="col">Сумма</th>
            <th scope="col">Просмотр</th>
            <th scope="col">Изменить</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
        <tr>
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
    name: "TagsShow",
    data() {
        return{
            'tag':null,
        }
    },
    mounted() {
        this.getTag();
    },
    methods:{
        getTag() {
            axios.get(`/api/vue/tags/${this.$route.params.id}`)
                .then(data => {
                    console.log(data.data);
                    this.tag = data.data.data})

        },
        deleteTag(id) {
            // console.log(id);
            axios.delete(`/api/vue/tags/${id}`)
                .then(res => {
                    // console.log(res.data);
                    this.$router.push({name: "tags.index"});
                });
        },
    }
}
</script>

<style scoped>

</style>
