<template>
    <div class="row">
        <div class="col-12">
            <div class="input-group">
                <input type="text" class="form-control form-control" v-model="searchRes" id="searchRes"
                       placeholder="поиск..." autocomplete="off">
                <SelectBar v-model="selectedSort" :options="sortOption"></SelectBar>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Сумма</th>
            <th scope="col">Сообщение</th>
            <th scope="col">Категория</th>
            <th scope="col">Просмотр</th>

        </tr>
        </thead>
        <tbody>
        <tr v-for="result in resultsSearchAndFilter">
            <th scope="row">{{ result.id }}</th>
            <td>{{ result.coast }}</td>
            <td>{{ result.message }}</td>
            <td>{{ result.category_id ? result.category.title : 'категория не определена' }}</td>
            <td>
                <router-link class="btn btn-outline-primary" :to="{ name:'results.show', params: {id: result.id}}">
                    Show
                </router-link>
            </td>

        </tr>

        </tbody>
    </table>

    <progress></progress>
    <div class="observer"></div>
</template>

<script>
import SelectBar from "../../widget/SelectBar.vue";

export default {
    name: "ResultsIndex",
    components: {SelectBar},
    data() {
        return {
            results: [],
            searchRes: '',
            limit: 20,
            selectedSort: '',
            sortOption: [
                {value: "id", name: "ID"},
                {value: "category_id", name: "По категории"},
                {value: "message", name: "По сообщению"},
            ]
        }
    },
    methods: {
        getResults() {
            axios.get(`/api/vue/results?+limit=${this.limit}`)
                .then(data => {
                    console.log(data.data);
                    this.results = data.data.data
                })

        },
        deleteResult(id) {
            // console.log(id);
            axios.delete(`/api/vue/results/${id}`)
                .then(res => {
                    // console.log(res.data);
                    this.getResults();
                });
        },
    },
    mounted() {
        this.getResults();

        let options = {
            rootMargin: '5px',
            threshold: 1.0
        }

        let observer = new IntersectionObserver((entries, b1) => {
            if (entries[0].isIntersecting === true) {
                console.log(entries);
                this.limit += 10;
                console.log(this.limit);

                this.getResults();
            }

        }, options);
        observer.observe(document.querySelector('.observer'));
        // console.log(observer);
    },
    computed: {
        resultsSort() {

            //  console.log(this.results);
            return [...this.results].sort((res1, res2) => {
                if (this.selectedSort == 'message') {
                    return res1[this.selectedSort]?.localeCompare(res2[this.selectedSort]);
                }
                return res1[this.selectedSort] - res2[this.selectedSort];
            })
        },
        resultsSearchAndFilter() {
            return this.resultsSort.filter(result => result.message.includes(this.searchRes))
        },

    },
    watch: {
        // selectedSort(newValue) {
        //
        //   //  console.log(this.results);
        //     this.results.sort((res1, res2) => {
        //         if(newValue == 'message'){
        //             return res1[newValue]?.localeCompare(res2[newValue]);
        //         }
        //         return  res1[newValue] - res2[newValue];
        //     })
        // }
    }
}
</script>

<style scoped>

</style>
