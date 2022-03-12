<template>
	<div class="sidebar">
		<!-- Sidebar user (optional) -->
		<!-- <sidebar-current-user /> -->

		<!-- SidebarSearch Form -->
		<!-- <sidebar-search-box /> -->

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul
				class="nav nav-pills nav-sidebar flex-column"
				data-widget="treeview"
				role="menu"
				data-accordion="false"
			>
				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library-->
			   <li class="nav-item" style="border-bottom: 1px solid #4b545c;">
				   <router-link to="/home" tag="a" class="nav-link">
				   		<i class="fas fa-tachometer-alt nav-icon"></i>
						<p>Dashboard</p>
				   </router-link>
				</li>

				<li class="nav-header">MAIN MENU</li>
				<li class="nav-item">
				   <router-link to="/resep" tag="a" class="nav-link">
				   		<i class="fas fa-book nav-icon"></i>
						<p>Resep Obat</p>
				   </router-link>
				</li>

					
				
				<!-- <li class="nav-header">SETTINGS</li> -->
				<!-- <li class="nav-item" v-if="$permission('user', 'view')">
				   <router-link to="/user" tag="a" class="nav-link">
				   		<i class="fas fa-users nav-icon"></i>
						<p>Users</p>
				   </router-link>
				</li> -->
				<!-- v-if="$permission('role', 'view')" -->
				<!-- <li class="nav-item">
				   <router-link to="/roles" tag="a" class="nav-link">
				   		<i class="fas fa-users-cog nav-icon"></i>
						<p>Roles</p>
				   </router-link>
				</li> -->
				
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
</template>

<script>
// import SidebarCurrentUser from '~/components/SidebarCurrentUser.vue';
// import SidebarSearchBox from '~/components/SidebarSearchBox.vue';
export default {
	// components: { SidebarCurrentUser, SidebarSearchBox },
	mounted() {
		$('[data-widget="treeview"]').Treeview("init");
	}
	
};
</script>