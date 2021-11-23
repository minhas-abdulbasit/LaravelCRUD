<template>
    <div>
        <h4 class="text-center">Add Company</h4>
        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="addCompany">
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
                        <input type="file" name='logo' @change="onFileChange" class="form-control" >
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add company</button>
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
    methods: {
        onFileChange(e) {
            const file = e.target.files[0];
            // this.url = URL.createObjectURL(file);
            this.selected_cover = file;
            console.log('file:',file,'cover:',this.selected_cover);
        },
        addCompany() {
            console.log(this.company);
            const formdata = new FormData();
            formdata.append('image', this.selected_cover)
            formdata.append('name', this.company.name)
            formdata.append('website', this.company.website)
            formdata.append('cover', URL.createObjectURL(this.selected_cover))
            formdata.append('email', this.company.email)
            console.log(formdata);
            // this.$axios.get('/sanctum/csrf-cookie').then(response => {
            //     this.$axios.post('/api/company/', this.company)
            //         .then(response => {
            //             console.log(response);
            //             this.$router.push({name: 'Company'})
            //         })
            //         .catch(function (error) {
            //             console.error(error);
            //         });
            // })
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