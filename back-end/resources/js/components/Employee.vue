<template>
    <div>
        <h4 class="text-center">All Employees</h4><br/>
        <button type="button" class="btn btn-info" @click="this.$router.push('/employee/add')">Add Employee</button>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Company</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in employees" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.first_name }}</td>
                <td>{{ employee.last_name }}</td>
                <td>{{ employee.phone }}</td>
                <td>{{ employee.email }}</td>
                <td>{{ employee.company_id }}</td>
                <td>{{ employee.created_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editemployee', params: { id: employee.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteEmployee(employee.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            employees: []
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/employee')
                .then(response => {
                    console.log(response);
                    this.employees = response.data.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        deleteEmployee(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/employee/${id}`)
                    .then(response => {
                        let i = this.employees.map(item => item.id).indexOf(id);
                        this.employees.splice(i, 1);
                        alert('Record Deleted!');
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