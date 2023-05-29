<template>
    <table class="table">
        <thead>
        <tr class="table-primary">
            <th style="width: 10px">Год</th>
            <th>Январь</th>
            <th>Февраль</th>
            <th>Март</th>
            <th>Апрель</th>
            <th>Май</th>
            <th>Июнь</th>
            <th>Июль</th>
            <th>Август</th>
            <th>Сентябрь</th>
            <th>Октябрь</th>
            <th>Ноябрь</th>
            <th>Декабрь</th>
            <th>Среднее</th>
            <th>Итого</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(arr, index)  in arrs">
            <th scope="row">{{ index }}</th>

            <td v-for="(a, i) in arr">{{ a }}</td>



        </tr>


        </tbody>
    </table>
</template>

<script>
export default {
    name: "GraphicAll",
    props: {
        'arrs': {},

    }


}
</script>

<style scoped>

</style>
