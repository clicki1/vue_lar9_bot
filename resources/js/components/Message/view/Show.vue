<template>
    <table class="table"  v-if="message">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Сообщение</th>
            <th scope="col">Сумма</th>
            <th scope="col">Дата</th>
            <th scope="col">Просмотр</th>
            <th scope="col">Изменить</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">{{ message.id }}</th>
            <td>
             {{message.message}}
            </td>
            <td>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="cst in message.coast">{{cst.coast}} руб.</li>
                </ul>
            </td>
            <td>{{message.created_at}}</td>
            <td><router-link class="btn btn-outline-primary" :to="{ name:'messages.show', params: {id: message.id}}">Show</router-link></td>
            <td><router-link class="btn btn-outline-success" :to="{ name:'messages.edit', params: {id: message.id}}">Edit</router-link></td>
            <td><a class="btn btn-outline-danger" href="#" @click.prevent="deleteMessage(message.id)"> Delete</a></td>
        </tr>

        </tbody>
    </table>
</template>

<script>
export default {
    name: "MessagesShow",
    data() {
        return{
            'message':null,
        }
    },
    mounted() {

        this.getMes();
    },
    methods:{
        getMes() {
            axios.get(`/api/vue/messages/${this.$route.params.id}`)
                .then(res => {
                    console.log(res.data.data);
                    this.message = res.data.data
                })
        },
        deleteMessage(id) {
            // console.log(id);
            axios.delete(`/api/vue/messages/${id}`)
                .then(res => {
                    this.$router.push({name: "messages.index"})
                });
        },
    }
}
</script>

<style scoped>

</style>
