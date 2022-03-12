<template>
	<div class="content-fluid">
		<portal to="header-title">
			<span>Resep</span>
			<nuxt-link tag="a" to="/resep/create" class="btn btn-primary" style="margin-left:1%;">
				<span><i class="fas fa-book"></i> Add</span>
			</nuxt-link>
		</portal>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Daftar Resep</h3>
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
				{ field: "nama_pasien", key: "b", title: "Nama Pasien", align: "left", sortBy: "" },
				{ 
					field: "nama_dokter", key: "c", title: "Dokter", align: "left", sortBy: "", 
					renderBodyCell: ({ row, column, rowIndex }, h) => {
                        const text = row[column.field];
						const tempat = row['tempat_periksa'];
						return (<div>
							<div><b>{text}</b></div>
							<div>Lokasi: {tempat}</div>
						</div>);
					} 	
				},
				{ field: "tanggal_periksa", key: "d", title: "Tgl. Periksa", align: "center", sortBy: "",  
					renderBodyCell: ({ row, column, rowIndex }, h) => {
                        const text = this.$moment(row[column.field]).format("lll")
						return text;
					} 
				},
				{ 
					field: "resep_obat", key: "e", title: "Jumlah Obat", align: "center", sortBy: "",  
					renderBodyCell: ({ row, column, rowIndex }, h) => {
                        const text = row[column.field].length
						return text;
					} 
				},
				{
					field: "is_draft",
					key: "h",
					title: "Status",
					align: "center",
					renderBodyCell: ({row, column, rowIndex}, h)=> {
						const status = row[column.field] == 1 ? 'draft' : 'approved';
						if (status == 'draft') {
							return (<button class="btn btn-warning btn-xs">Draft</button>);
						}

						return (<button class="btn btn-primary btn-xs">Approved</button>);
					},
					sortBy: "desc"
				},
				{
					field: "created_at",
					key: "f",
					title: "Created At",
					align: "center",
					renderBodyCell: ({row, column, rowIndex}, h)=> {
						const text = this.$moment(row[column.field]).format("lll")
						return text;
					},
					sortBy: "desc"
				},
				{
					field: "",
					key: "g",
					title: "Action",
					align: "center",
					renderBodyCell: ({row, column, rowIndex}, h)=> {
						return (
							
							<div class="btn-group btn-block">
								<button type="button" class="btn btn-warning btn-sm" on-click={()=> 1}>
									<i class="fas fa-edit"></i>
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
				const { data } = await this.$axios.get(`resep`, {
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
				title: 'Sure to delete resep?',
				showCancelButton: true,
				confirmButtonText: `Ok, Delete!`,
			}).then(async (result) => {

				if (result && !result.dismiss) {
					this.$nuxt.$loading.start();
					try {

						await this.$axios.delete(`resep/${id}`);
						
						this.$swal.fire('Deleted successfully!', '', 'success');
						this.getDataFromApi();
						this.$nuxt.$loading.finish();

					} catch (error) {

						this.$swal.fire('Delete failed!', '', 'danger');
						this.$nuxt.$loading.finish();

					}
				} 
				
				if (result && result.dismiss) {
					this.$swal.fire('Resep are not deleted', '', 'info');
				}
			})

			
		},


		/**
		 * On demand methods
		 * 
		 */
		
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