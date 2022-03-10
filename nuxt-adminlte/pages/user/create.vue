<template>
	<div class="content-fluid">
		<portal to="header-title">
			<span>Add User</span>
		</portal>

		<div class="row">
			<div class="col-md-6">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">New User</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form @submit.prevent="createUser" class="form-horizontal">
						<div class="card-body">
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-3 col-form-label"
									>Fullname</label
								>
								<div class="col-sm-8">
									<input
										v-model="form.fullname"
										type="text"
										class="form-control"
										id="fullname"
										placeholder="Fullname" 
										:class="{ 'is-invalid': form.errors.has('fullname') }"
									/>
									<has-error :form="form" field="fullname"></has-error>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-sm-3 col-form-label"
									>Email</label
								>
								<div class="col-sm-8">
									<input
										v-model="form.email"
										type="email"
										class="form-control"
										id="inputEmail3"
										placeholder="Email"
										:class="{ 'is-invalid': form.errors.has('email') }"
									/>
									<has-error :form="form" field="email"></has-error>
								</div>
							</div>
							<div class="form-group row">
								<label
									for="inputPassword3"
									class="col-sm-3 col-form-label"
									>Password</label
								>
								<div class="col-sm-8">
									<input
										v-model="form.password"
										type="password"
										class="form-control"
										id="inputPassword3"
										placeholder="Password"
										:class="{ 'is-invalid': form.errors.has('password') }"
									/>
									<has-error :form="form" field="password"></has-error>
								</div>
							</div>
							<div class="form-group row">
								<label
									for="password_confirmation"
									class="col-sm-3 col-form-label"
									>Password Confirmation</label
								>
								<div class="col-sm-8">
									<input
										v-model="form.password_confirmation"
										type="password"
										class="form-control"
										id="password_confirmation"
										placeholder="Password Confirmation"
										:class="{ 'is-invalid': form.errors.has('password_confirmation') }"
									/>
									<has-error :form="form" field="password_confirmation"></has-error>
								</div>
							</div>
							<div class="form-group row">
								<label for="role" class="col-sm-3 col-form-label"
									>Role</label
								>
								<div class="col-sm-8">
									<select class="form-control" id="role" v-model="form.role">
										<option value="">---</option>
										<option v-for="(item, index) in listOfRoles.data" :key="index" :value="item.slug">
											{{ item.name }}
										</option>
									</select>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-info">Sign in</button>
							<nuxt-link tag="a" to="/user" class="btn btn-default float-right">
								Cancel
							</nuxt-link>
						</div>
						<!-- /.card-footer -->
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Form from "vform";

export default {
	data(){
		return {
			form: new Form({
				fullname: '',
				email: '',
				password: '',
				password_confirmation: '',
				role: ''
			})
		}
	},

	async asyncData({ $axios }){
		const listOfRoles = await $axios.get(`admin/roles`, {
			params: {
				'list_only': true
			}
		});

		return {
			listOfRoles
		}
	},

	methods: {
		async createUser(){
			this.$nuxt.$loading.start();
			try {

				await this.$axios.post(`admin/users`, this.form);

				this.$nuxt.$loading.finish();
				this.$router.push(`/user`);
			} catch (error) {
				console.log('ERROR!!', error);

				if (error.response && error.response.status == 422) {
					this.$nextTick(() => {
						this.form.errors.set(error.response.data.errors);
					});

					this.$toast.error(`${error.response.data.message}`, {
						icon: "exclamation-triangle",
						iconPack: "fontawesome",
						duration: 5000,
					});	

				} else if(error.response && error.response.status == 403) {
					let message = "Action failed.";

					if (error.response.data) {
						message = error.response.data.message;
					}

					this.$toast.error(`${message}`, {
						icon: "exclamation-triangle",
						iconPack: "fontawesome",
						duration: 4000,
					});	
				} else {
					this.$toast.error(`Error on submitting form!.`, {
						icon: "exclamation-triangle",
						iconPack: "fontawesome",
						duration: 5000,
					});	
				}

				

				this.$nuxt.$loading.finish();

			}
		}
	}
};
</script>

<style>
</style>