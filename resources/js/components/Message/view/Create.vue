<template>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Добавить сообщение</th>

                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>
                        <div class="input-group">
                            <span class="input-group-text">₽</span>
                            <input type="text" class="form-control" v-model="message" placeholder="введите текущие расходы" >
                            <button type="submit" :disabled="isDisabled" class="btn btn-success" @click.prevent="store()" ><i class="bi bi-send"></i> Добавить</button>
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
    data() {
        return{
            message: null
        }
    },
    name: "MessagesCreate",
    components:{

    },
    methods:{
        store(){
            axios.post('/api/vue/messages', {message: this.message})
                .then(res => {
                    console.log(res.data);
                     this.$router.push({name: "messages.index"})
                })
        },


    },
    computed:{
        isDisabled(){
            return !this.message;
        }
    }
}
</script>

<style scoped>

</style>
