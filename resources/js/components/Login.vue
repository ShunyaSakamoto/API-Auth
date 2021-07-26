<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form @submit.prevent="login">

                            <!-- メールアドレス -->
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-bind:class="{'is-invalid': emailError}" name="email" v-model="form.email" autocomplete="Off" autofocus>

                                    <span v-if="emailError" class="invalid-feedback" role="alert">
                                        <strong>{{ error.email[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <!-- パスワード -->
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" v-bind:class="{'is-invalid': passwordError}" name="password" v-model="form.password" autocomplete="Off">

                                    <span v-if="passwordError" class="invalid-feedback" role="alert">
                                        <strong>{{ error.password }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-3">
                                    <button class="btn btn-dark btn-block">Login</button>
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
            emailError: false,
            passwordError: false,
            form: {
                email: "",
                password: ""
            },
            error: [],
            user: {}
        };
    },
    methods: {
        validateEmail() {
            // 未入力チェック
            if (this.form.email == "") {
                this.error.email = new Array('Email address is required.');
                this.emailError = true;
            } else {
                this.emailError = false;
            }
        },
        validatePassword() {
            // 未入力チェック
            if (this.form.password == "") {
                this.error.password = new Array('Password is required.');
                this.passwordError = true;
            } else {
                this.passwordError = false;
            }
        },
        login() {
            this.validateEmail();
            this.validatePassword();

            if (this.emailError || this.passwordError) {
                return;
            }

            axios.post("/api/login", {
                email: this.form.email,
                password: this.form.password
            })
            .then(res => {
                this.emailError = false;
                this.user = res.data;
                localStorage.setItem("token", this.user.token);
                this.$router.push("/dashboard");
                // console.log(this.user);
            })
            .catch(err => {
                this.error = err.response;
                this.emailError = true;
                console.log(err.response);
            });
        }
    }
}
</script>