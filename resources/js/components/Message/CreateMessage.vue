<template>

            <div class="row g-3">
                <div class="col-12">
                    <div class="input-group has-validation justify-content-center m-auto">
                        <span class="input-group-text">₽</span>
                        <input type="text" class="form-control form-control-lg" v-model="message" id="message"
                               placeholder="введите текущие расходы" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="justify-content-center m-auto">
                        <button class="btn btn-primary btn-lg w-50" type="submit" @click.prevent="addMessage()"><i class="bi bi-send"></i></button>
                    </div>

                </div>
            </div>

</template>

<script>
export default {
    data() {
        return{
            message: null
        }
    },
    name: "CreateMessage",
    methods:{
        addMessage() {
            console.log(this.message);
            axios.post('/api/vue/messages', {message: this.message})
                .then(res => {console.log(res.data)
                this.message = null})
            this.$parent.$refs.index.getMessage();

        },
    }
}
</script>

<style scoped>

</style>
