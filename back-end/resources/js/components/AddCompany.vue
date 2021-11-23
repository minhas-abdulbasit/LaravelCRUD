<template>
    <div>
        <h4 class="text-center">Add Company</h4>
        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="addCompany">
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="formData.name">
                    </div>
                    <div class="form-group  col-md-6">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="formData.email">
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label>Website</label>
                        <input type="text" class="form-control" v-model="formData.website">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Logo</label>
                        <input type="file" ref="file" @change="onFileChange" class="form-control" >
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add company</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
export default {
    data() {
        return {
            company: {},
            formData: {
                name: null,
                email: null,
                website: null
            },
            logo: null,
            logoName: null,
        }
    },
    methods: {
        onFileChange(e) {
            this.logo = this.$refs.file.files[0]
            this.logoName = this.logo.name
            console.log('logo:',this.logo,'logoName:',this.logoName);
        },
        addCompany() {
            // console.log(this.company);
            let formData = new FormData()
            _.each(this.formData, (value, key) => {
                formData.append(key, value)
            })
            formData.append('logo', this.logo)
            console.log(formData);
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/company/', formData,
                { headers: {
                    'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }}).then(response => {
                        console.log(response);
                        this.$router.push({name: 'Company'})
                    })
                    .catch(function (error) {
                        console.log('here');
                        alert('something went wrong!');
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