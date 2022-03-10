<template>
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<!-- style="opacity: 0.8; width: 3rem; margin-top: -1rem;" -->
				<img
					src="~static/upcore/icons/logo-example-64.png"
					alt="UpCore001 Logo"
					class="brand-image"
					style="opacity: 0.8; width: 20%;"
				/>
				<!-- <a href="/" class="h1"><b>{{ appName }}</b></a> -->
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to start your session</p>
				<form @submit.prevent="userLogin">
				<div class="input-group mb-3">
					<input v-model="login.email" type="email" class="form-control" placeholder="Email" />
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input
						v-model="login.password"
						type="password"
						class="form-control"
						placeholder="Password"
					/>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-8">
						<!-- <div class="icheck-primary">
								<input type="checkbox" id="remember" />
								<label for="remember"> Remember Me </label>
							</div> -->
					</div>
					<!-- /.col -->
					<div class="col-4">
						<button
							type="submit"
							class="btn btn-primary btn-block"
							:disabled="loading"
						>
							<span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
							<span v-if="!loading">Sign In</span>
						</button>
					</div>
					<!-- /.col -->
				</div>
				</form>

				<div class="social-auth-links text-center mt-2 mb-3">
					<!-- <a href="#" class="btn btn-block btn-primary">
						<i class="fab fa-facebook mr-2"></i> Sign in using Facebook
					</a>
					<a href="#" class="btn btn-block btn-danger">
						<i class="fab fa-google-plus mr-2"></i> Sign in using Google+
					</a> -->
				</div>
				<!-- /.social-auth-links -->

				<!-- <p class="mb-1">
					<router-link to="/forgot">I forgot my password</router-link>
				</p> -->
				<!-- <p class="mb-0">
					<router-link to="/register" class="text-center">Register a new membership</router-link>
				</p> -->
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->
</template>

<script>
export default {
	layout: "guest",
	head: {
		bodyAttrs: {
			class: "hold-transition login-page",
			style: "",
		},
	},
	data(){
		return {
			appName: process.env.APP_NAME,
			login: {
				email: "",
				password: "",
			},
			loading: false
		}
	},
	methods: {
		async userLogin() {
			this.loading = true;
			try {
				let response = await this.$auth.loginWith("local", {
					data: this.login,
				});

				if (response && this.$auth.loggedIn) {
					this.$toast.success(`Successfully authenticated.`, {
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
					
					// this.$store.dispatch("roles/fetchUserRoles");					
					this.loading = false;
					this.$router.push({ path: '/' });
				}		

			} catch (err) {
				this.$toast.error(`Unauthenticated.`, {
					icon: "exclamation-triangle",
					iconPack: "fontawesome",
					theme: 'outline',
					position: 'bottom-center',
					action : {
						text : 'Close',
						onClick : (e, toastObject) => {
							toastObject.goAway(0);
						}
					},
				});	
				// console.log(err);
				this.loading = false;
			}			
		},
	},
};
</script>

<style scoped>

@media only screen and (max-width: 600px) {
  .login-box, .register-box {
		margin-top: 0.5rem;
		width: 100%;
		padding: 1rem;
	}
}

</style>