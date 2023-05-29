<template>
    <table class="table"  v-if="result">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Сумма</th>
            <th scope="col">Сообщение</th>
            <th scope="col">Категория</th>


        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">{{ result.id }}</th>
            <td>{{result.coast}}</td>
            <td>{{result.message}}</td>
            <td>
                <div class="input-group input-group-sm">
                    <select class="form-select form-select-sm" v-model="category_id">
                        <option class="bg-purple" disabled value="null" selected>Выберите категорию</option>
                        <template v-for="category in categories">
                            <option class="bg-gray-dark" :value="category.id"
                                    :selected="result.category_id"
                            >{{category.title}}</option>
                        </template>
                    </select>
                    <button type="submit" class="btn btn-outline-success"  @click.prevent="updateResult()"><i
                        class="bi bi-arrow-return-left"></i> Изменить
                    </button>
                </div>

            </td>

        </tr>

        </tbody>
    </table>
</template>

<script>
export default {
    name: "ResultsShow",
    data() {
        return{
            'result':null,
            categories: {},
            category_id:null
        }
    },
    mounted() {

        this.getResult();
        this.getCategories();
    },
    methods:{
        getResult() {
            axios.get(`/api/vue/results/${this.$route.params.id}`)
                .then(res => {
                    console.log(res.data.data);
                    this.result = res.data.data;
                    this.category_id = res.data.data.category_id;
                })
        },
        getCategories() {
            axios.get('/api/vue/categories')
                .then(data => {
                    console.log(data.data);
                    this.categories = data.data.data})

        },
        updateResult() {
            // console.log(id);
            axios.patch(`/api/vue/results/${this.$route.params.id}`, {'category_id': this.category_id})
                .then(res => {
                    // console.log(res.data);
                    this.$router.push({name: "results.index"})
                });
        },
        deleteResult(id) {
            // console.log(id);
            axios.delete(`/api/vue/results/${id}`)
                .then(res => {
                    // console.log(res.data);
                    this.$router.push({name: "results.index"})
                });
        },
    }
}
</script>

<style scoped>

</style>
