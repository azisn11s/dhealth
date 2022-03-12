<template>
	<div class="content-fluid">
		<portal to="header-title">
			<span>Edit User</span>
		</portal>

		<div class="row">
			<div class="col-md-6">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">User</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form @submit.prevent="editUser" class="form-horizontal">
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
							<button type="submit" class="btn btn-info">Submit</button>
							<nuxt-link tag="a" to="/user" class="btn btn-default float-right">
								Cancel
							</nuxt-link>
						</div>
						<!-- /.card-footer -->
					</form>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Associated Employee</h3>
					</div>
						<div class="card-body">

							<div class="row">
								<div class="col-12 col-sm-12">
									<div class="form-group">
										<label>Employee</label>
										<!-- :reduce="company => company.code" -->
										<v-select 
											@open="onOpenEmployees" @search="fetchEmployeeOptions" 
											:options="employees"
											v-model="selectedEmployee"
											:class="{'is-invalid': formErrors.has('employee_id')}"
											placeholder="Select an employee"
											>
											<template v-slot:option="option">
												<div><strong>{{ option.label }}</strong></div> 
												<div class="text-muted">(Emp. Code {{ option.employee_code }}) at {{ option.company_name }}</div>
											</template>
										</v-select>
										<has-error :form="form" field="employee_id"></has-error>
									</div>
								</div>
							</div>
						</div>
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
			employees: []
		}
	},

	async asyncData({ params, $axios }){
		const user = await $axios.get(`admin/users/${params.id}`).then((resp)=> {
			return resp.data.data;
		});

		const listOfRoles = await $axios.get(`admin/roles`, {
			params: {
				'list_only': true
			}
		});

		const selectedEmployee = await $axios.get(`user-employee/${user.id}`).then((resp)=> {
			if (resp.data.success) {
				return [{
					code: resp.data.data.id,
					label: `${resp.data.data.first_name} ${resp.data.data.last_name}`
				}]
			}

			return null;
		});

		return {
			listOfRoles,
			form : new Form({
				fullname: user.name,
				email: user.email,
				role: '',
				password: '',
				password_confirmation: '',
				employee_id: ''
			}),
			selectedEmployee
		}
	},

	methods: {
		async editUser(){
			this.$nuxt.$loading.start();
			try {

				await this.$axios.put(`admin/users/${this.$route.params.id}`, this.form);

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
		},

		fetchEmployeeOptions(search, loading){
			this.$axios.get(`search-employee`, {params: {
				term: search
			}}).then((resp)=> {
				if (resp.data.items) {
					this.employees = resp.data.items
				}
			})
		},

		onOpenEmployees() {
			this.$axios.get(`search-employee`).then((resp)=> {
				if (resp.data.items) {
					this.employees = resp.data.items
				}
			})
		}
	},

	computed: {
		formErrors(){
			return this.form.errors;
		}
	},

	watch: {
		selectedEmployee: function (newVal, oldVal) {
			if (newVal) {
				this.form.employee_id = newVal.code
			}
		}
	}

};
</script>

<style>
</style>