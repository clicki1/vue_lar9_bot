<template>
    <tr :class="this.$parent.isEdit(message.id) ? '' : 'd-none'">
        <th scope="row">{{ message.id }}</th>
        <td>
            <input type="text" class="form-control" v-model="edit_mess">
        </td>
        <td><a href="#" class="btn btn-outline-success" @click.prevent="updateMessage(message.id)">update</a></td>
        <td><a href="#" class="btn btn-outline-danger" @click.prevent="this.$parent.deleteMessage(message.id)">Delete</a></td>
    </tr>
</template>

<script>
export default {
    data() {
        return {
            edit_mess: null,
            messages: [],
        }
    },
    props: [
        'message'
    ],
    name: "EditMessage",
    computed: {
        // getId() {
        //     return this.persons.filter((category) =>{
        //         return category.id > 3}
        //     )
        // },
    },

    methods: {
        updateMessage(id) {
            // console.log(id);
            axios.patch(`/api/vue/messages/${id}`, {message: this.edit_mess})
                .then(data => {
                    // console.log(data);
                });
            console.log(this.$parent);
            this.$parent.indexLog();
            this.$parent.getMessage();
            this.edit_mess = null;
        },
        editLog() {
            console.log('This is EditComponent - brother');
        },
    },
}
</script>

<style scoped>

</style>
