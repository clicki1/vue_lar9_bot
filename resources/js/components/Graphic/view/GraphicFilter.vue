<template>

    <table class="table" v-if="arrs_filter[0]">
        <thead>
        <tr>
            <th scope="col">Сумма</th>
            <th scope="col">Месяц</th>
            <th scope="col">Год</th>
        </tr>
        </thead>
        <tbody v-for="(arrs, index) in arrs_filter[0]">
        <tr  v-for="arr in arrs">
            <td v-for="a in arr">{{ a }}</td>
        </tr>

        </tbody>
    </table>
    <table class="table" v-if="arrs_filter[1]">
        <thead>
        <tr>
            <th scope="col">Сумма</th>
            <th scope="col">Категория</th>
            <th scope="col">Год</th>
        </tr>
        </thead>
        <tbody  v-for="(arrs, index) in arrs_filter[1]">
        <tr  v-for="arr in arrs">
            <td v-for="a in arr">{{ a }}</td>
            </tr>

        </tbody>
    </table>
</template>

<script>
export default {
    name: "GraphicFilter.vue",
    props: {
        'arrs_filter': {},
        'category_id':null

    },
    computed:{
        cat_title() {
            return this.category_id ? 'yesy' : 'no';
        },
    }
}
</script>

<style scoped>

</style>
