<template>
    <select class="form-select" v-model="valSelect"
            @change.prevent="sortOptions">
        <option value="" disabled>Способ сортировки</option>
        <option v-for="option in options" :key="option.value" :value="option.value">{{ option.name }}
        </option>

    </select>
</template>

<script>
export default {
    name: "SelectBar",
    data() {
        return {
            valSelect: "",

        }
    },
    props: {
        modelValue: {
            type: String,
        },
        options: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        url_location() {
            return document.location.host;
        },
    },
    mounted() {

    },
    methods: {
        sortOptions(event) {
         //   console.log(event.target.value);
            this.$emit('update:modelValue', this.valSelect)
          //  this.$emit('update:modelValue', event.target.value)
        }
    }
}
</script>

<style scoped>
.selected_bar {
    margin-top: 40px;
}
</style>
