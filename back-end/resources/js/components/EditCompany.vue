<template>
    <div>
        <h4 class="text-center">Edit Company</h4>
        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="updateCompany">
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="company.name">
                    </div>
                    <div class="form-group  col-md-6">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="company.email">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label>Website</label>
                        <input type="text" class="form-control" v-model="company.website">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Logo</label>
                        <input type="file" class="form-control" >
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Company</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            company: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/company/${this.$route.params.id}/edit`)
                .then(response => {
                    console.log(response.data);
                    this.company = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        updateCompany() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.put(`/api/company/${this.$route.params.id}`, this.company)
                    .then(response => {
                        console.log(response);
                        this.$router.push({name: 'Company'});
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
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