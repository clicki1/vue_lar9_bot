<template>
    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold">Доходы & Расходы</h1>
        <div class="col-lg-6 mx-auto">
            <btn-base ref="btn"></btn-base>
            <create-message></create-message>
            <index-message ref="index"></index-message>

        </div>
    </div>
</template>

<script>
import BtnBase from "./BtnBase.vue";
import IndexMessage from "./Message/IndexMessage.vue";
import CreateMessage from "./Message/CreateMessage.vue";
export default {
    name: "BaseComponent",
    components: {BtnBase, IndexMessage, CreateMessage},
    methods:{
        baseLog() {
            console.log('This is BaseComponent - PARENT');
        },
    },
    mounted() {
       // console.log('Component -BaseComponent- mounted.'),
       console.log(this.$refs.btn.btnLog())
    }
}
</script>

<style scoped>

</style>
