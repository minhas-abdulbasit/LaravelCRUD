<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;border-bottom:1px solid;">
            <span class="text-secondary"><b>CRUD APP</b></span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" style="border-bottom:2px solid;">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="isLoggedIn" >
                    <router-link to="/company" class="nav-item nav-link">Companies</router-link>
                    <router-link to="/employees" class="nav-item nav-link">Employees</router-link>
                    <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <router-link to="/login" class="nav-item nav-link">Login</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {
        logout(e) {
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data == "Logged out!") {
                            console.log(response.data)
                            window.location.href = "/login"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>