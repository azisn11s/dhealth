<template>
	<div class="content-fluid">
		<portal to="header-title">
			<span>Edit Role - #{{ form.slug || form.id }}</span>
		</portal>

		<div class="row">
			<div class="col-md-6">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Role</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form @submit.prevent="edit" class="form-horizontal">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label"
									>Role</label
								>
								<div class="col-sm-8">
									<input
										v-model="form.name"
										type="text"
										class="form-control"
										id="name"
										placeholder="Role Name" 
										:class="{ 'is-invalid': form.errors.has('name') }"
									/>
									<has-error :form="form" field="name"></has-error>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label"
									>Slug</label
								>
								<div class="col-sm-8">
									<input
										v-model="form.slug"
										type="text"
										class="form-control"
										placeholder="Role"
										:class="{ 'is-invalid': form.errors.has('role') }"
									/>
									<has-error :form="form" field="role"></has-error>
								</div>
							</div>
							<div class="form-group row">
								<label
									class="col-sm-3 col-form-label"
									>Status</label
								>
								<div class="col-sm-8">
									<input type="checkbox" v-model="form.status" class="form-check-input" id="status">
									<label class="form-check-label" for="status">Active</label>
									<has-error :form="form" field="status"></has-error>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label"
									>Description</label
								>
								<div class="col-sm-8">
									<textarea v-model="form.description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
									<has-error :form="form" field="description"></has-error>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label"
									>Permissions</label
								>
								<div class="col-sm-8">
									<textarea disabled v-model="form.permissions" class="form-control" :class="{ 'is-invalid': form.errors.has('permissions') }"></textarea>
									<has-error :form="form" field="permissions"></has-error>
								</div>
							</div>

						</div>
						<!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-info">Update</button>
							<nuxt-link tag="a" to="/roles" class="btn btn-default float-right">
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
		return {}
	},

	async asyncData({ params, $axios }){
		const role = await $axios.get(`admin/roles/${params.id}`).then((resp)=> {
			return resp.data.data;
		});

		return {
			form : new Form({
				name: role.name,
				slug: role.slug,
				description: role.description,
				status: role.status
			})
		}
	},

	methods: {
		async edit(){
			this.$nuxt.$loading.start();
			try {

				await this.$axios.put(`admin/roles/${this.$route.params.id}`, this.form);

				this.$nuxt.$loading.finish();
				this.$router.push(`/roles`);
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