<template>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Изменить сообщение</th>

                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>
                        <div class="input-group">
                            <span class="input-group-text">₽</span>
                            <input type="text" class="form-control" v-model="text" id="message" placeholder="введите текущие расходы" >
                            <button type="submit" :disabled="isDisabled" class="btn btn-success"  @click.prevent="update()" ><i class="bi bi-send"></i> Изменить</button>
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
    name: "MessagesEdit",
    data() {
        return {
            text: null,
        }
    },
    methods: {
        getMes() {
            axios.get(`/api/vue/messages/${this.params}/edit`)
                .then(res => this.text = res.data.data.message)
        },
        update() {
            axios.patch(`/api/vue/messages/${this.params}`, {message: this.text})
                .then(res => {
                    this.$router.push({name: "messages.index"})
                });
        }
    },
    mounted() {
        this.getMes();
        // console.log(this.$route.params.id);
        // console.log(this.params);
    },
    computed: {
        params() {
            return this.$route.params.id;
        },
        isDisabled(){
            return !this.text;
        }
    },
}
</script>

<style scoped>

</style>
