<template>
	<div class="content-fluid">
		<portal to="header-title">
			<span>Tambah Resep Obat</span>
		</portal>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Detail Resep</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<div class="form-horizontal">
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 col-form-label"
											>Nama Pasien</label
										>
										<div class="col-sm-8">
											<input
												v-model="form.nama_pasien"
												type="text"
												class="form-control"
												id="nama_pasien"
												placeholder="Nama Pasien" 
												:class="{ 'is-invalid': form.errors.has('nama_pasien') }"
											/>
											<has-error :form="form" field="nama_pasien"></has-error>
										</div>
									</div>
									<div class="form-group">
										<label
											for="inputPassword3"
											class="col-sm-3 col-form-label"
											>Tempat Periksa</label
										>
										<div class="col-sm-8">
											<input
												v-model="form.tempat_periksa"
												type="text"
												class="form-control"
												id="inputtempat_periksa3"
												placeholder="Tempat Periksa"
												:class="{ 'is-invalid': form.errors.has('tempat_periksa') }"
											/>
											<has-error :form="form" field="tempat_periksa"></has-error>
										</div>
									</div>
									<div class="form-group">
										<label
											for="tanggal_periksa"
											class="col-sm-3 col-form-label"
											>Tanggal Periksa</label
										>
										<div class="col-sm-8">
											<date-picker
												name="tanggal_periksa"
												:input-class="{
													'form-control': true,
													'is-invalid': form.errors.has('tanggal_periksa'),
												}"
												placeholder="Pilih tanggal"
												format="d MMMM yyyy"
												minimum-view="day"
												maximum-view="year"
												:monday-first="true"
												v-model="form.tanggal_periksa"
												:typeable="false"
												:clear-button="true"
												clear-button-icon="fa fa-times"
												:bootstrap-styling="true"
											>
												<has-error
													slot="afterDateInput"
													:form="form"
													field="tanggal_periksa"
												></has-error>
											</date-picker>
										</div>
									</div>
									
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 col-form-label"
											>Dokter</label
										>
										<div class="col-sm-8">
											<input
												v-model="form.nama_dokter"
												type="text"
												class="form-control"
												id="inputnama_dokter3"
												placeholder="Nama Dokter"
												:class="{ 'is-invalid': form.errors.has('nama_dokter') }"
											/>
											<has-error :form="form" field="nama_dokter"></has-error>
										</div>
									</div>
									<div class="form-group">
										<label for="role" class="col-sm-3 col-form-label"
											>Catatan</label
										>
										<div class="col-sm-8">
											<textarea
												class="form-control"
												v-model="form.catatan"
												placeholder="Catatan"
											></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Daftar Obat</h3>
					</div>
					<table class="table">
						<thead>
							<th width="5%">No.</th>
							<th width="20%">Tipe</th>
							<th width="30%">Obat</th>
							<th width="12%">Qty.</th>
							<th width="30%">Signa</th>
							<th></th>
						</thead>
						<tbody>
							<tr v-for="(val, idx) in form.list_obat" :key="idx">
								<td>
									{{idx + 1}}.
								</td>
								<td>
									<!-- v-model="form.list_obat[idx].type" -->
									<select class="form-control" v-model="form.list_obat[idx].type">
										<option v-for="(tipe, idT) in tipe_obat" :key="idT" :value="tipe.value">
											<span>{{ tipe.text }}</span>
										</option>
									</select>
								</td>
								<td>
									<v-select
										@open="onOpenObat"
										@search="fetchObatOptions"
										:options="listObat"
										v-model="form.list_obat[idx].obat"
										:class="{
											'is-invalid':
												form.errors.has(`list_obat.${idx}.id`),
										}"
										placeholder="Pilih obat"
									>
									</v-select>
								</td>
								<td>
									<input type="number" min="0" v-model="form.list_obat[idx].quantity" class="form-control">
								</td>
								<td>
									<v-select
										@open="onOpenSigna"
										@search="fetchSignaOptions"
										:options="listSigna"
										v-model="form.list_obat[idx].signa"
										:class="{
											'is-invalid':
												form.errors.has(`list_obat.${idx}.signa_id`),
										}"
										placeholder="Pilih signa"
									>
									</v-select>
								</td>
								<td>
									<button type="button" class="btn btn-danger btn-sm" @click="deleteItemObat(idx)"> 
										<i class="fas fa-trash"></i>
									</button>
								</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="4">
									<button class="btn btn-primary" @click="addRowObat">
										<span>
											<i class="fa fa-plus"></i> Tambah Obat
										</span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<form @submit.prevent="createResep">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-footer">
						<button type="submit" class="btn btn-info btn-lg float-right">Submit</button>
						<nuxt-link tag="a" to="/user" class="btn btn-default btn-lg float-right">
							Cancel
						</nuxt-link>
					</div>
					<!-- /.card-footer -->
				</div>
			</div>
		</div>
		</form>
		
	</div>
</template>

<script>
import Form from "vform";

export default {
	data(){
		return {
			form: new Form({
				nama_pasien: '',
				nama_dokter: '',
				tempat_periksa: '',
				tanggal_periksa: '',
				catatan: '',
				list_obat: [
					{
						type: "",
						quantity: "",
						obat: null,
						signa: null,
					},{
						type: "",
						quantity: "",
						obat: null,
						signa: null,
					}
				]
			}),
			tipe_obat: [{value: 'nonracikan', text: 'Non-Racikan'}, {value: 'racikan', text: 'Racikan'}],
		}
	},

	async asyncData({ $axios }){

		const listObat = await $axios.get(`obat-search`).then((resp)=>{
			if (resp.data && resp.data.items.length) {
				return resp.data.items;
			}

			return []
		})

		const listObatRacikan = await $axios.get(`resep-racikan-search`).then((resp)=>{
			if (resp.data && resp.data.items.length) {
				return resp.data.items;
			}

			return []
		})

		const listSigna = await $axios.get(`signa-search`).then((resp)=>{
			if (resp.data && resp.data.items.length) {
				return resp.data.items;
			}

			return []
		})

		return {
			listObat,
			listObatRacikan,
			listSigna
		}
	},

	methods: {
		async createResep(){
			this.$nuxt.$loading.start();
			try {

				await this.$axios.post(`resep`, this.form);

				this.$nuxt.$loading.finish();
				this.$router.push(`/resep`);
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

		fetchObatOptions(search, loading) {
			this.$axios
				.get(`obat-search`, {
					params: {
						term: search,
					},
				})
				.then((resp) => {
					if (resp.data.items) {
						this.listObat = resp.data.items;
					}
				});
		},

		onOpenObat() {
			this.$axios.get(`obat-search`).then((resp) => {
				if (resp.data.items) {
					this.listObat = resp.data.items;
				}
			});
		},

		fetchSignaOptions(search, loading) {
			this.$axios
				.get(`signa-search`, {
					params: {
						term: search,
					},
				})
				.then((resp) => {
					if (resp.data.items) {
						this.listSigna = resp.data.items;
					}
				});
		},

		onOpenSigna() {
			this.$axios.get(`signa-search`).then((resp) => {
				if (resp.data.items) {
					this.listSigna = resp.data.items;
				}
			});
		},

		deleteItemObat(index){
			console.log('Mau happus index', index);
			this.form.list_obat = this.form.list_obat.filter((item, idx)=> {
				// console.log('idx', idx);
				// console.log('item', item);
				return idx != index;
			}); 
		},

		addRowObat(){
			let rowObat = {
				type: "",
				quantity: "",
				obat: null,
				signa: null,
			}

			this.form.list_obat.push(rowObat);
		}
	},

	watch: {
		// "form.list_obat.*.selected_obat": function(newValue){
		// 	console.log('selected obat', newValue);
		// }
	}
};
</script>

<style>
</style>