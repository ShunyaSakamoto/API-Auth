<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Account Information</div>

                    <div class="card-body">

                        <form @submit.prevent="logout">

                            <!-- Name -->
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name：</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control-plaintext" name="name" v-model="user.name" readonly>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email Address：</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control-plaintext" name="email" v-model="user.email" readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-3">
                                    <button class="btn btn-dark btn-block">Logout</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {}
        };
    },
    methods: {
        getUser() {
            axios.get("/api/user/?api_token=" + localStorage.getItem("token"))
                .then(res => {
                    this.user = res.data;
                    // console.log(this.user);
                })
                .catch(err => {
                    console.log(err.response);
                });
        },
        logout() {
            axios.post("/api/logout")
                .then(res => {
                    localStorage.removeItem("token");
                    this.$router.push("/login");
                    // console.log(res.data);
                })
                .catch(err => {
                    console.log(err.response);
                })
        }
    },
    mounted() {
        this.getUser();
    }
}
</script>