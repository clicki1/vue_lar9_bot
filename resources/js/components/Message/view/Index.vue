<template>

    <table class="table">
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
        <tr v-for="message in messages">
            <th scope="row">{{ message.id }}</th>
            <td>{{ message.message }}</td>
            <td>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="cst in message.coast">{{ cst.coast }} руб.</li>
                </ul>
            </td>
            <td>{{ message.created_at }}</td>
            <td>
                <router-link class="btn btn-outline-primary" :to="{ name:'messages.show', params: {id: message.id}}">
                    Show
                </router-link>
            </td>
            <td>
                <router-link class="btn btn-outline-success" :to="{ name:'messages.edit', params: {id: message.id}}">
                    Edit
                </router-link>
            </td>
            <td><a class="btn btn-outline-danger" href="#" @click.prevent="deleteMessage(message.id)"> Delete</a></td>
        </tr>

        </tbody>
    </table>
    <progress></progress>
    <div class="observer"></div>

</template>

<script>
export default {
    name: "MessagesIndex",
    data() {
        return {
            messages: [],
            limit: 20,

        }
    },
    methods: {
        getMessage() {
            axios.get(`/api/vue/messages?+limit=${this.limit}`)
                .then(data => {
                    console.log(data.data);
                    console.log(localStorage.getItem("chat_id"));
                    this.messages = data.data.data
                })

        },
        deleteMessage(id) {
            // console.log(id);
            axios.delete(`/api/vue/messages/${id}`)
                .then(res => {
                    // console.log(res.data);
                    this.getMessage();
                });
        },
    },
    mounted() {
        this.getMessage();

        let options = {
            rootMargin: '5px',
            threshold: 1.0,
           // numSteps:20
        }

        let observer = new IntersectionObserver((entries) => {
            console.log(entries[0].isIntersecting);
            if (entries[0].isIntersecting === true) {
                console.log(entries);
                this.limit += 10;
                console.log(this.limit);

                this.getMessage();
            }

        }, options);
        observer.observe(document.querySelector('.observer'));
        // console.log(observer);
        console.log(111);
        console.log(this.message_filter);
        console.log(222);
    },
    computed: {
        chat_id() {
            return localStorage.getItem("chat_id");
        } ,

    }

}
</script>

<style scoped>

</style>
