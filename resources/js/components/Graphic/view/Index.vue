<template>
    <div class="row">
        <div class="col-12">
            <div class="input-group mb-2">
                <select class="form-select" aria-label="Default select example" id="category_id" @change="onChange()"
                        v-model="category_id">
                    <option selected value="">Категория</option>
                    <template v-for="cat in categories">
                        <option :value="cat.id">{{ cat.title }}</option>
                    </template>
                </select>
                <select class="form-select" aria-label="Default select example" @change="onChange()" v-model="year_res">
                    <option selected="" value="">Год</option>
                    <template v-for="(year, index)  in years">
                        <option :value="year">{{ year }}</option>
                    </template>

                </select>
                <select class="form-select" aria-label="Default select example" @change="onChange()"
                        v-model="month_res">

                    <option selected="" value=''>Месяц</option>
                    <template v-for="(month, index)  in months">
                        <option :value="+index">{{ month }}</option>
                    </template>


                </select>

                <button @click.prevent="reload()" class="btn btn-outline-secondary" id="button22">Сбросить</button>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12" v-if="arrs_filter.length === 0">

            <GraphicAll :arrs="arrs"></GraphicAll>

        </div>
        <div class="col-12" v-else>
            <GraphicFilter :category_id="category_id" :arrs_filter="arrs_filter"></GraphicFilter>
        </div>
    </div>

</template>

<script>
import GraphicAll from "./GraphicAll.vue";
import GraphicFilter from "./GraphicFilter.vue";

export default {
    name: "GraphicIndex",
    components: {
        GraphicAll, GraphicFilter
    },

    data() {
        return {
            categories: {},
            category_id: '',
            data: {},
            months: {},
            month_res: '',
            years: {},
            year_res: '',
            arrs_filter: {},
            arrs: {},


        }
    },
    methods: {
        getCategories() {
            axios.get('/api/vue/categories')
                .then(data => {
                    // console.log(data.data.data);
                    this.categories = data.data.data
                })

        },
        reload() {
            this.month_res = '';
            this.year_res = '';
            this.data = {};
            this.arrs_filter = {};
            this.category_id = '';
            this.category = {};
            this.getGraphics();
        },
        getGraphics() {
            axios.get('/api/vue/graphic')
                .then(data => {
                 //   console.log(data.data);
                    this.months = data.data.months;
                    this.years = data.data.years;
                    this.arrs = data.data.arrs;
                    this.arrs_filter = data.data.arrs_filter;
                })

        },
        onChange() {
            console.log(this.category_id);
            //if(this.year_res)
            axios.get(`/api/vue/graphic?month_res=${+this.month_res}&category_id=${+this.category_id}&year_res=${+this.year_res}`)
                .then(data => {
                  //  console.log(data.data.data);
                  //  this.months = data.data.months;
                    this.year_res = data.data.data.year_res;
                  //  this.arrs = data.data.arrs;
                    this.arrs_filter = data.data.arrs_filter;

                })
        },

    },
    mounted() {
        this.getCategories();
        this.getGraphics();
    }
}
</script>

<style scoped>

</style>
