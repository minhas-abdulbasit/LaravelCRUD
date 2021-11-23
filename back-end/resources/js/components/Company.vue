<template>
    <div>
        <h4 class="text-center">All Companies</h4><br/>
        <button type="button" class="btn btn-info" @click="this.$router.push('/company/add')">Add Company</button>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Website</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="company in companies" :key="company.id">
                <td>{{ company.id }}</td>
                <td>{{ company.logo }}</td>
                <td>{{ company.name }}</td>
                <td>{{ company.website }}</td>
                <td>{{ company.email }}</td>
                <td>{{ company.created_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editcompany', params: { id: company.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteCompany(company.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <pagination :data="companies" @pagination-change-page="getResults"></pagination>
    </div>
</template>

<script>
export default {
    data() {
        return {
            companies: {}
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/company')
                .then(response => {
                    console.log(response.data.data);
                    this.companies = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        deleteCompany(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/company/${id}`)
                    .then(response => {
                        alert('Record Deleted!');
                        let i = this.companies.map(item => item.id).indexOf(id); // find index of your object
                        this.companies.splice(i, 1)
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