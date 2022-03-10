<template>
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"
					><i class="fas fa-bars"></i
				></a>
			</li>
			<!-- <li class="nav-item d-none d-sm-inline-block">
				<a href="" class="nav-link">Home</a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="#" class="nav-link">Contact</a>
			</li> -->
		</ul>

		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			
			<!-- User's Profile -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
					<span class="d-sm-none"><i class="far fa-user"></i></span> 
					<span class="d-none d-lg-block">
						<i class="far fa-user"></i> 
						{{ $auth.user.name }} ({{ $auth.user.email }})
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<div style="padding: 20px;" class="small">
						<div><b>{{ $auth.user.name }}</b></div>
						<div>({{ $auth.user.email }})</div>
						<span class="text-muted">
							<i>Registerd  at {{ $moment($auth.user.created_at).format('d MMM YYYY') }}</i>
						</span>
					</div>					
					<div class="dropdown-divider"></div>
					<a @click.prevent="logout" class="dropdown-item dropdown-footer"
						>
						<i class="fas fa-power-off"></i>
						<span>Logout</span>
					</a
					>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-widget="fullscreen" href="#" role="button">
					<i class="fas fa-expand-arrows-alt"></i>
				</a>
			</li>
		</ul>
	</nav>
</template>

<script>
export default {
    methods: {
		async logout(){
			try {
				await this.$auth.logout();

				this.$toast.success(`Successfully logged out.`, {
					icon: "check",
					iconPack: "fontawesome",
					duration: 5000,
					theme: 'outline',
					position: 'top-center',
					action : {
						text : 'Close',
						onClick : (e, toastObject) => {
							toastObject.goAway(0);
						}
					},
				});	

				this.$router.push({path: '/login'})


			} catch (error) {
				this.$toast.error(`Unauthenticated.`, {
					icon: "exclamation-triangle",
					iconPack: "fontawesome",
					duration: 5000,
				});	

				console.log(error);
			}

		}
	}
};
</script>