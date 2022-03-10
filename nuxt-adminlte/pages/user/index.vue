<template>
	<div class="content-fluid">
		<portal to="header-title">
			<span>User</span>
			<nuxt-link tag="a" to="/user/create" class="btn btn-primary" style="margin-left:1%;">
				<span><i class="fas fa-user-plus"></i> Add</span>
			</nuxt-link>
			<button class="btn btn-success" @click="()=> { this.exportToExcel(); }">
				<span><i class="fas fa-file-excel"></i>  Export to Excel</span>
			</button>
		</portal>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">User List</h3>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="max-width: 200px;">
								<input type="text" v-model="searchFilter" @keyup="()=> { this._.delay(()=> this.getDataFromApi(), 1000) }" class="form-control float-right" placeholder="Search">

								<div class="input-group-append">
								<button type="submit" class="btn btn-default" @click="()=> { this.getDataFromApi();}">
									<i class="fas fa-search"></i>
								</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<vue-element-loading :active="isLoading" :is-full-screen="false"/>
						<ve-table :columns="columns" :table-data="tableData" id="table-container" :sort-option="sortOption" />
						<div class="table-pagination">
                            <!-- 'sizer', 'jumper' -->
							<ve-pagination
								:total="totalCount"
								:page-index="pageIndex"
								:page-size="pageSize"
								@on-page-number-change="pageNumberChange"
								@on-page-size-change="pageSizeChange"
								:layout="['total', 'prev', 'pager', 'next']"
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<style scoped>
.table-pagination {
	margin-top: 20px;
	text-align: right;
}
</style>

<script>
export default {
	data() {
		return {
            loadingInstance: null,
			isLoading: false,
			columns: [
				{
					field: "",
					key: "a",
					title: "No.",
					width: 50,
					align: "center",
					renderBodyCell: ({ row, column, rowIndex }, h) => {
						// return ++rowIndex;
                        return (this.pageIndex - 1) * this.pageSize + 1 + rowIndex;
					}					
				},
				{ field: "name", key: "b", title: "Fullname", align: "left", sortBy: "" },
				{ field: "email", key: "c", title: "Email", align: "left" },
				{ field: "user_id", key: "g", title: "Employee Code", align: "center", 
				renderBodyCell: ({ row, column, rowIndex }, h) => {
                        return row['employee'] ? row['employee'].employee_code : "-";
					} 
				},
				{
					field: "created_at",
					key: "d",
					title: "Created At",
					align: "center",
					renderBodyCell: ({row, column, rowIndex}, h)=> {
						const text = this.$moment(row[column.field]).format("lll")
						return text;
					},
					sortBy: "desc"
				},
				{
					field: "email_verified_at",
					key: "e",
					title: "Verified At",
					align: "center",
					renderBodyCell: ({row, column, rowIndex}, h)=> {
						if (!row[column.field]) {
							return (<i class="text-purple">Unverified</i>);
						}

						const text = this.$moment(row[column.field]).format("lll")
						return text;
					},
					sortBy: ""
				},
				{
					field: "",
					key: "f",
					title: "Action",
					align: "center",
					renderBodyCell: ({row, column, rowIndex}, h)=> {
						return (
							<div class="btn-group btn-block">
								<button type="button" class="btn btn-warning btn-sm" on-click={()=> this.$router.push(`user/${row['id']}/edit`)}>
									<i class="fas fa-edit"></i>
								</button>
								<button type="button" class="btn btn-info btn-sm" on-click={()=> this.setDefaultPassword(row['id'])}>
									<i class="fas fa-key"></i>
								</button>
								<button type="button" class="btn btn-danger btn-sm" on-click={()=> this.deleteRow(row['id'])}> 
									<i class="fas fa-trash"></i>
								</button>
							</div>
						);
					}
				},
			],
			// page index
			pageIndex: 1,
			// page size
			pageSize: 10,
			totalCount: 0,
			tableData: [],
            searchFilter: "",
			sortParams: {},
			sortOption: {
				// sort always
				sortAlways: true,
				sortChange: (params) => {
					// console.log("sortChange::", params);
					if (Object.keys(params).length) {
						this.sortParams = params;
						this.$nextTick(()=>{
							this.getDataFromApi();
						});
					}
				},
			},
		};
	},
    
	methods: {

		/**
		 * Required methods
		 * 
		 */

		// page number change
		pageNumberChange(pageIndex) {
			this.pageIndex = pageIndex;
            this.getDataFromApi();
		},

		// page size change
		pageSizeChange(pageSize) {
			this.pageIndex = 1;
			this.pageSize = pageSize;
            this.getDataFromApi();
		},

		// Get table data from API
		async getDataFromApi() {
			this.isLoading = true;
            // this.loadingInstance.show();
			try {
				const { data } = await this.$axios.get(`admin/users`, {
					params: {
						page: this.pageIndex,
						per_page: this.pageSize,
						search: this.searchFilter,
						sort: this.sortParams
					},
				});

				this.totalCount = data.total;
				this.tableData = data.data;
				this.isLoading = false;

			} catch (error) {
				// console.log("ERROR!!!!!!!!!!!", error);
				this.$toast.global.server_error();
				this.isLoading = false;
			}
		},

		deleteRow(id){

			this.$swal.fire({
				title: 'Sure to delete user?',
				showCancelButton: true,
				confirmButtonText: `Ok, Delete!`,
			}).then(async (result) => {

				if (result && !result.dismiss) {
					this.$nuxt.$loading.start();
					try {

						await this.$axios.delete(`admin/users/${id}`);
						
						this.$swal.fire('Deleted successfully!', '', 'success');
						this.getDataFromApi();
						this.$nuxt.$loading.finish();

					} catch (error) {

						this.$swal.fire('Delete failed!', '', 'danger');
						this.$nuxt.$loading.finish();

					}
				} 
				
				if (result && result.dismiss) {
					this.$swal.fire('User are not deleted', '', 'info');
				}
			})

			
		},


		/**
		 * On demand methods
		 * 
		 */
		setDefaultPassword(id){
			this.$swal.fire({
				title: 'Will use default password ?',
				showCancelButton: true,
				confirmButtonText: `Continue`,
			}).then(async (result) => {

				if (result && !result.dismiss) {
					console.log('RESULT', result);
					this.$nuxt.$loading.start();
					try {

						await this.$axios.patch(`admin/users/${id}/default-password`);
						
						this.$swal.fire('Password change successfully!', '', 'success');
						this.getDataFromApi();
						this.$nuxt.$loading.finish();

					} catch (error) {

						this.$swal.fire('Failed change password!', '', 'danger');
						this.$nuxt.$loading.finish();

					}
				} 
			})

			
		},

		async exportToExcel(){
			try {
				this.$nuxt.$loading.start();

				const api = this.$axios.create({
					responseType: 'blob',
				});

				await api.get(`admin/users/export-excel`)
					.then((response) => {
						const blob = new Blob([response.data], {
							type: response.data.type,
						});
						const url = window.URL.createObjectURL(blob);

						const link = document.createElement("a");
						link.href = url;

						link.setAttribute("download", "user-export.xlsx");
						document.body.appendChild(link);
						link.click();
						link.remove();
						window.URL.revokeObjectURL(url);

					});

				this.$nuxt.$loading.finish();
			} catch (err) {
				if (err.response && !err.response.data.success) {
					this.$swal.fire(
						`Gagal, ${err.response.data.message}`,
						"",
						"error"
					);
				} else {
					if (err.response && err.response.data.code == 422) {
						this.$nextTick(() => {
							this.form.errors.set(err.response.data.error);
						});
						this.$toast.error("Mohon cek kembali formulir Anda", {
							icon: "times",
							iconPack: "fontawesome",
							duration: 5000,
						});
					} else if (err.response && err.response.data.code == 403) {
						this.$swal.fire(
							`Gagal, ${err.response.data.error}`,
							"",
							"error"
						);
					} else {
						this.$swal.fire(
							"Terjadi kesalahan",
							"Silakan hubungi Admin",
							"error"
						);
					}
				}

				this.$nuxt.$loading.finish();
			}
		}
	},

	/**
	 * Lifecycle
	 * 
	 */
	created() {
		this.getDataFromApi();
	},
	mounted() {
		// this.loadingInstance = this.$veLoading
		//   veLoading({
		//     target:"#table-container",
		//     name: "wave",
		// 	tip: "Loading..."
		//   });
    },
};
</script>