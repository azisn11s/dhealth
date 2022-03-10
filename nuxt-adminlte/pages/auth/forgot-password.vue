<template>
	<div class="login-box">
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">
					You forgot your password? Here you can easily retrieve a new
					password.
				</p>
				<form @submit.prevent="userForgot">
					<div class="input-group mb-3">
						<input
							type="email"
							class="form-control"
							placeholder="Email"
							v-model="forgot.email"
							:class="{ 'is-invalid': forgot.errors.has('email') }"
						/>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
						<has-error :form="forgot" field="email" />
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">
								Request new password
							</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<p class="mt-3 mb-1">
					<router-link to="/login" class="text-center">Login</router-link>
				</p>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->
</template>

<script>
import {Form} from "vform";

export default {
    layout: "guest",
    head: {
		bodyAttrs: {
			class: "hold-transition login-page",
            style: ""
		},
	},
	data() {
		return {
			forgot: new Form({
				email: "",
			}),
		};
	},
	methods: {
		async userForgot() {
			try {

                let response = await this.$axios.post(`/password/email`, this.forgot);
				
				this.$toast.success(`Please check your email inbox. We've send you email reset link!`, {
					icon: "check",
					iconPack: "fontawesome",
					duration: 5000,
					theme: 'outline',
					position: 'top-center',
					action : {
						text : 'Close',
						onClick : (e, toastObject) => {
							toastObject.goAway(0);
						}
					},
				});	
				
			} catch (error) {

				if (error.response && error.response.status == 422) {
					this.$nextTick(() => {
						this.forgot.errors.set(error.response.data.errors);
					});
				}

				this.$toast.error(`Request failed!`, {
					icon: "exclamation-triangle",
					iconPack: "fontawesome",
					duration: 5000,
				});
				console.log(error);
			}
		},
	},
};
</script>

<style>
</style>