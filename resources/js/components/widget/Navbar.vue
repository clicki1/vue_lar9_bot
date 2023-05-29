<template>

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <router-link class="navbar-brand" :to="{name: 'base.index'}">Chat: {{ +chat_id }}</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item no_show">
                            <router-link class="nav-link" :to="{name: 'messages.index'}">Сообщения</router-link>
                        </li>

                        <li class="nav-item no_show">
                            <router-link class="nav-link" :to="{name: 'categories.index'}">Категории</router-link>
                        </li>

                        <li class="nav-item no_show">
                            <router-link class="nav-link" :to="{name: 'tags.index'}">Тэги</router-link>
                        </li>

                        <li class="nav-item no_show">
                            <router-link class="nav-link" :to="{name: 'results.index'}">Результаты</router-link>
                        </li>

                        <li class="nav-item no_show">
                            <router-link class="nav-link" :to="{name: 'graphics.index'}">Графики</router-link>
                        </li>

                        <li class="nav-item  dropdown">
                            <a class="nav-link btn btn-outline-success" href="#" data-bs-toggle="dropdown"
                               aria-expanded="false">ДОБАВИТЬ</a>
                            <ul class="dropdown-menu">
                                <li class="no_show">
                                    <router-link class="dropdown-item" :to="{name: 'messages.create'}">- сообщение
                                    </router-link>
                                </li>
                                <li class="no_show">
                                    <router-link class="dropdown-item" :to="{name: 'categories.create'}">- категорию
                                    </router-link>
                                </li>
                                <li class="no_show">
                                    <router-link class="dropdown-item" :to="{name: 'tags.create'}">- тег</router-link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-flex">
                            <button class="nav-link btn btn-outline-dark" @click.prevent="logout()">Выйти</button>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </header>

</template>

<script>
export default {
    name: "Navbar",
    props: {
        chat_id: Number
    },
    computed: {
        url_location() {
            return document.location.host;
        },
    },
    mounted() {
        // console.log(this.url_location);
        let el_show = document.querySelector("#navbarCollapse");
        let no_shs = document.querySelectorAll("li.no_show");

        no_shs.forEach((userItem) => {
            userItem.onclick = function (e){
                el_show.classList.remove('show');
            };
        });
    },
    methods: {
        logout() {
            localStorage.removeItem('chat_id');
            window.location.replace("http://" + this.url_location + "/vue");
            // axios.post('http://127.0.0.1:8000/api/logout')
            //     .then(data => {
            //
            //         console.log(data.data);
            //         localStorage.removeItem('chat_id')
            //         console.log(localStorage.getItem('chat_id'));
            //
            //     })
            //
            // this.$router.push({name: "base.index"})
        }
    }
}
</script>

<style scoped>

</style>
