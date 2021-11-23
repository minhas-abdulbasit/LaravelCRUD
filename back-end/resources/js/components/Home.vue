<template>
    <div>
        Welcome {{ name }},

        This is a basic Laravel CRUD App with vue spa.
    </div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            name: null,
        }
    },
    created() {
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name;
            console.log(this.name);
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    }
}
</script>