<template>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">messages</th>
            <th scope="col">update</th>
            <th scope="col">delete</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="message in messages">
            <ShowMessage :message="message" ref="show"></ShowMessage>

            <EditMessage :message="message" :ref='`edit_${message.id}`'></EditMessage>
        </template>
        </tbody>
    </table>
    <div class="observer"></div>
</template>

<script>
import EditMessage from "./EditMessage.vue";
import ShowMessage from "./ShowMessage.vue";

export default {
    data() {
        return {
            messages: [],
            edit_mess: null,
            editMessageId: null
        }


    },
    props: {
       // 'chat_id': String
    },
    components: {
        EditMessage, ShowMessage
    },
    name: "IndexMessage",
    computed: {
        // getId() {
        //     return this.persons.filter((category) =>{
        //         return category.id > 3}
        //     )
        // },
    },
    mounted() {
        this.getMessage()

    },
    methods: {
        getMessage() {
            axios.get('/api/vue/messages')
                .then(data => {
                    console.log(data.data);
                    this.messages = data.data.data})
            this.editMessageId = null;
            console.log(localStorage.getItem("chat_id"));
        },
        isEdit(id) {
            return this.editMessageId === id;
        },

        deleteMessage(id) {
            // console.log(id);
            axios.delete(`/api/vue/messages/${id}`)
                .then(res => {
                    console.log(res.data);
                    this.getMessage();
                });
        },
        indexLog() {
            //  this.changeEditMessageId(null);
            console.log('This is IndexComponent - brother');
        },


    },

}
</script>

<style scoped>

</style>
