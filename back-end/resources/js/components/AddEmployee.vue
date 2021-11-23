<template>
    <div>
        <h4 class="text-center">Add Employee</h4>
        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="addEmployee">
                    <div class="row">
                    <div class="form-group col-md-4">
                        <label>First Name</label>
                        <input type="text" class="form-control" v-model="employee.first_name">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Last Name</label>
                        <input type="text" class="form-control" v-model="employee.last_name">
                    </div>
                    <div class="form-group  col-md-4">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="employee.email">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label>Phone</label>
                        <input type="text" class="form-control" v-model="employee.phone">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Company ID</label>
                        <input type="text" class="form-control"  v-model="employee.company_id">
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add employee</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            employee: {}
        }
    },
    methods: {
        addEmployee() {
            console.log(this.employee);
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/employee/', this.employee)
                    .then(response => {
                        console.log(response.data);
                        this.$router.push({name: 'Employees'})
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