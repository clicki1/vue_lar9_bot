<template>
    <ul class="list-group" v-for="category in categories">
        <li class="list-group-item">id: {{category.id}}, title: {{category.title}}</li>
    </ul>
</template>

<script>
export default {
    data() {
     return {
         categories: [
             {
                 id: 1,
                 title: 'one'
             },
             {
                 id: 2,
                 title: 'two'
             },
             {
                 id: 3,
                 title: 'tree'
             },
             {
                 id: 4,
                 title: 'four'
             },
         ]
     }


    },
    name: "CatagoryCatalog",
    computed:{
        // getId() {
        //     return this.persons.filter((category) =>{
        //         return category.id > 3}
        //     )
        // },
    },
    mounted() {
        // this.getCategory()
    },
    methods: {
        // getCategory() {
        //     axios.get('http://127.0.0.1:8000/api/cat')
        //         .then(data => this.categories = data.data)
        //
        // },

    },

}
</script>

<style scoped>

</style>
