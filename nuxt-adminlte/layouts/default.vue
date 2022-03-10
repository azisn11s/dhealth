<template>
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<Navbar />
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="" class="brand-link navbar-white">
				<img
					src="~static/upcore/icons/logo-example-64.png"
					alt="UpCore001 Logo"
					class="brand-image"
				/>
				<span class="brand-text font-weight-light">{{ appName }}</span>
			</a>

			<!-- Sidebar -->
			<Sidebar />
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-8">
							<portal-target name="header-title" tag="h1"></portal-target>
						</div>
						<div class="col-sm-4">
							<!-- Breadcrumbs Component -->
							<portal-target name="breadcrumbs"></portal-target>
						</div>
					</div>
				</div>
				<!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<Nuxt />
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

    <Footer />
		
	</div>
	<!-- ./wrapper -->
</template>

<script>
import Navbar from "~/components/app/Navbar";
import Sidebar from "~/components/app/Sidebar";
import Footer from "~/components/app/Footer";
export default {
  components: {
    Navbar,
    Sidebar,
    Footer
  },
	data() {
		return {
			appName: process.env.APP_NAME
		};
	},

	head: {
		bodyAttrs: {
			class: "hold-transition sidebar-mini",
		},
	},

	middleware: 'auth'

};
</script>

<style scoped>
.brand-link .brand-image {
    float: none;
    line-height: 0.8;
    margin-left: .8rem;
    margin-right: .5rem;
    margin-top: -3px;
    max-height: 63px;
    width: auto;
}
</style>
