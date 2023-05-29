<template>
    <tr :class="this.$parent.isEdit(message.id) ? 'd-none' : ''">
        <th scope="row">{{ message.id }}</th>
        <td>{{ message.message }}</td>
        <td><a href="#" @click.prevent="changeEditMessageId(message.id, message.message)"
               class="btn btn-outline-dark">Edit</a></td>
        <td><a href="#" class="btn btn-outline-danger" @click.prevent="this.$parent.deleteMessage(message.id)">Delete</a></td>
    </tr>
</template>

<script>
export default {
    name: "ShowMessage",
    props:[
        'message'
    ],
    methods: {
        changeEditMessageId(id, message) {
            console.log(message);
            console.log(this.$parent.$refs["edit_" + id][0].edit_mess);
            this.$parent.editMessageId = id;
            this.$parent.$refs["edit_" + id][0].edit_mess = message;
        },
    }

}
</script>

<style scoped>

</style>
