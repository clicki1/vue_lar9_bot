<template>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Изменить категорию</th>

                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input type="text" class="form-control" v-model="title" id="title" placeholder="введите название категории" >
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
    name: "CategoriesEdit",
    data() {
        return {
            title: null,
        }
    },
    methods: {
        getCategory() {
            axios.get(`/api/vue/categories/${this.$route.params.id}`)
                .then(res => {
                    console.log(res.data.data);
                    this.title = res.data.data.title
                })
        },
        update() {
            axios.patch(`/api/vue/categories/${this.params}`, {title: this.title})
                .then(res => {
                    this.$router.push({name: "categories.show", params: {id: this.$route.params.id}})
                });
        }
    },
    mounted() {
        this.getCategory();
    },
    computed: {
        params() {
            return this.$route.params.id;
        },
        isDisabled(){
            return !this.title;
        }
    },
}
</script>

<style scoped>

</style>
