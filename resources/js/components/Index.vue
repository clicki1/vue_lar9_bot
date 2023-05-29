<template>

    <navbar v-if="isAuth" :chat_id="chat_id"></navbar>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <router-view v-if="isAuth"></router-view>
                <div v-else class="px-4 py-5 my-5 text-center">
                    <h1 class="display-5 fw-bold">Мои Расходы</h1>
                    <div class="col-lg-6 mx-auto">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg" name="chat_id" id="chat_id"
                                   v-model="chat_id"
                                   placeholder="введите chat_id" autocomplete="off">
                            <button class="btn btn-outline-dark" id="enter" @click.prevent="getAuth(chat_id)"
                                    v-on:keyup.enter.prevent="getAuth(chat_id)">Войти
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import Navbar from "./widget/Navbar.vue";

export default {
    name: "Index",
    data() {
        return {
            isAuth: false,
            chat_id: null
        }


    },


    mounted() {
        document.addEventListener('keydown', function (event) {
            if (event.keyCode === 13) {
                document.getElementById("enter").click();
            }
        })
        let url = new URL(window.location.href);
        if (url.searchParams.get('key')) {
            this.getAuthKey(url.searchParams.get('key'));
        } else {
         //   console.log(localStorage.getItem("chat_id"));
            this.getAuth(localStorage.getItem("chat_id"));
        }
    },
    methods: {

        getAuthKey(id) {
            this.isAuth = false;
            axios.post('http://127.0.0.1:8000/api/loginkey', {'key': id})
                .then(data => {
                 //   console.log(data.data);
                    this.chat_id = data.data.chat_id;
                    this.isAuth = data.data.ok;
                    if (this.chat_id) {
                        localStorage.setItem('chat_id', this.chat_id);
                        this.$router.push({name: "messages.index"})
                    }

                })

        },
        getAuth(id) {
            console.log(222);
            this.isAuth = false;
            axios.post('http://127.0.0.1:8000/api/login', {'chat_id': id})
                .then(data => {
                 //   console.log(data.data);
                    this.isAuth = data.data.ok;
                    this.chat_id = data.data.chat_id;
                    if (this.chat_id) {
                        localStorage.setItem('chat_id', this.chat_id);
                        this.$router.push({name: "messages.index"})
                    }

                })

        },
    },
    computed: {
        // a computed getter
        chat_idnew() {
            // `this` points to the component instance
            return localStorage.getItem("chat_id");
        },// a computed getter
        isAuthnew() {
            // `this` points to the component instance
            return localStorage.getItem("auth");
        },
    },


    components: {Navbar}
}
</script>

<style scoped>

</style>
