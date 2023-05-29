<template>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <button type="button" disabled class="btn btn-primary btn-lg px-4 gap-3">{{ plus }} *</button>
        <a href="">
            <button type="button" class="btn btn-outline-secondary btn-lg px-4">{{ minus }} *</button>
        </a>
    </div>
</template>

<script>
export default {
    name: "BtnBase",
    data() {
        return {
            plus: "Доход",
            minus: "Расход"
        }
    },
    methods:{
        btnLog() {
            console.log('This is BtnComponent');
        },
    },
    mounted() {
        console.log(this.$parent.baseLog());
        console.log(this.$parent.$refs.index.indexLog());
    }

}
</script>

<style scoped>

</style>
