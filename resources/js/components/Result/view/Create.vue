<template>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Добавить категорию</th>

                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input type="text" class="form-control" v-model="title" placeholder="введите название категории" >
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
            title: null
        }
    },
    name: "CategoryCreate",
    components:{

    },
    methods:{
        store(){
            axios.post('/api/vue/categories', {title: this.title})
                .then(res => {
                    this.$router.push({name: "categories.index"})
                })
        },


    },
    computed:{
        isDisabled(){
            return !this.title;
        }
    }
}
</script>

<style scoped>

</style>
