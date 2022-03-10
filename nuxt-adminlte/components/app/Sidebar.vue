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
				<li class="nav-item" v-if="$permission('country', 'view')">
				   <router-link to="/countries" tag="a" class="nav-link">
				   		<i class="fas fa-globe-americas nav-icon"></i>
						<p>Country</p>
				   </router-link>
				</li>
				<li class="nav-item" v-if="$permission('region', 'view')">
				   <router-link to="/regions" tag="a" class="nav-link">
				   		<i class="fas fa-map nav-icon"></i>
						<p>Region</p>
				   </router-link>
				</li>
				<li class="nav-item" v-if="$permission('area', 'view')">
				   <router-link to="/areas" tag="a" class="nav-link">
				   		<i class="fas fa-map-marked-alt nav-icon"></i>
						<p>Area</p>
				   </router-link>
				</li>
				<li class="nav-item" v-if="$permission('territory', 'view')">
				   <router-link to="/territories" tag="a" class="nav-link">
				   		<i class="fas fa-globe nav-icon"></i>
						<p>Territory</p>
				   </router-link>
				<li class="nav-item" v-if="$permission('company', 'view')">
				   <router-link to="/companies" tag="a" class="nav-link">
				   		<i class="fas fa-building nav-icon"></i>
						<p>Company</p>
				   </router-link>
				</li>
				<li class="nav-item" v-if="$permission('employee', 'view')">
				   <router-link to="/employees" tag="a" class="nav-link">
				   		<i class="fas fa-user-tie nav-icon"></i>
						<p>Employee</p>
				   </router-link>
				</li>	

				<li class="nav-header" v-if="$permission('doctor', 'view')">DOCTORS</li>
				<li class="nav-item" v-if="$permission('doctor', 'view')">
				   <router-link :to="{path: '/doctors'}" replace tag="a" class="nav-link">
				   		<i class="fas fa-user-md nav-icon"></i>
						<p>Doctor</p>
				   </router-link>
				</li>	
				<li class="nav-item" v-if="$permission('doctor', 'view')">
				   <router-link to="/doctors/specialties" tag="a" class="nav-link">
				   		<i class="fas fa-user-tag nav-icon"></i>
						<p>Specialty</p>
				   </router-link>
				</li>
				<li class="nav-item" v-if="$permission('doctor', 'view')">
				   <router-link to="/doctors/classifications" tag="a" class="nav-link">
				   		<i class="fas fa-layer-group nav-icon"></i>
						<p>Classification</p>
				   </router-link>
				</li>		

				<li class="nav-header" v-if="$permission('team', 'view')">TEAMS</li>
				<li class="nav-item" v-if="$permission('team', 'view')">
				   <router-link :to="{path: '/teams'}" replace tag="a" class="nav-link">
				   		<i class="fas fa-user-friends nav-icon"></i>
						<p>Team</p>
				   </router-link>
				</li>			
				
				<li class="nav-header">SETTINGS</li>
				<li class="nav-item" v-if="$permission('user', 'view')">
				   <router-link to="/user" tag="a" class="nav-link">
				   		<i class="fas fa-users nav-icon"></i>
						<p>Users</p>
				   </router-link>
				</li>
				<!-- v-if="$permission('role', 'view')" -->
				<li class="nav-item">
				   <router-link to="/roles" tag="a" class="nav-link">
				   		<i class="fas fa-users-cog nav-icon"></i>
						<p>Roles</p>
				   </router-link>
				</li>
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