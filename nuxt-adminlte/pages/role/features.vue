<template>
	<div class="content-fluid">
		<portal to="header-title">
			<span>Role's Features - #{{ form.slug || form.id }}</span>
		</portal>

		<div class="row">
			<div class="col-md-6">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Role</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form class="form-horizontal">
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
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Features -->
		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-header">
						<div class="card-title">Features</div>
					</div>
					<table class="table">
						<thead>
							<th>No.</th>
							<th>Feature</th>
							<th>Abilities</th>
						</thead>
						<tbody>
							<tr v-for="(feature, key) in features" :key="`${key}-${feature.slug}`">
								<td>{{++key}}</td>
								<td>
									<div><strong>{{feature.name}}</strong></div>
									<div class="text-muted" v-if="feature.description">{{feature.description}}</div>
								</td>
								<td class="container-abilities">
									<div v-for="(action, key) in feature.actions" :key="`${key}-${action}`" class="item-abilities">
										<div class="custom-control custom-switch">
											<input 
												type="checkbox" class="custom-control-input" 
												:id="`${key}-${feature.slug}-${action}`" 
												:value="`${key}-${feature.slug}-${action}`"
												:checked="existingFeatures.filter((ft)=> ft.slug == feature.slug)[0] ? existingFeatures.filter((ft)=> ft.slug == feature.slug)[0]['pivot']['abilities'][action] : false" 
												@change="submitFeatureAbility($event, feature.slug, action)">
											<label class="custom-control-label" :for="`${key}-${feature.slug}-${action}`">{{action}}</label>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
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

		const features = await $axios.get(`admin/features`, {params: {
			list_only: 1
		}}).then((resp)=> {

			if (resp.data.length) {
				return resp.data.filter((feature)=> {
					return feature.is_active;
				});
			}
			return [];
		});

		return {
			features,
			form : new Form({
				id: role.id,
				name: role.name,
				slug: role.slug,
				description: role.description,
				status: role.status
			}),
			existingFeatures: role.features
		}
	},

	methods: {
		async submitFeatureAbility(e, feature, ability){

			try {
				const resp = await this.$axios.post(`admin/role-features/${this.form.id}`, {
					feature: feature,
					ability: ability,
					ability_value: e.target.checked
				});

				if (resp.data.success && resp.data.data.features.length) {
					this.existingFeatures = resp.data.data.features;
				}

			} catch (error) {
				console.log('ERROR SUBMIT ABILITY...', error);
				this.$toast.error(`Error on updating ability!.`, {
						icon: "exclamation-triangle",
						iconPack: "fontawesome",
						duration: 3000,
					});	
			}
		}
	}
};
</script>

<style scoped>
.container-abilities{
	display: flex;
}
.item-abilities{
	margin-right: 1rem;
}
</style>