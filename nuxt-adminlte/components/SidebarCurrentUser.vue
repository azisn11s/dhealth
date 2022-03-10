<template>
	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
			<img
				src="~static/upcore/icons/person-1.png"
				class="img-circle elevation-2"
				alt="User Image"
			/>
		</div>
		<div class="info">
			<div>
				<a href="#" class="d-block">{{ $auth.user.name }}</a>
			</div>
			<div>
				<a href="#" class="d-block small">{{ $auth.user.email }}</a>
			</div>
		</div>
	</div>
</template>

<script>
export default {};
</script>

<style scoped>
.user-panel img {
	background-color: aliceblue;
	width: 3.1rem;
}
</style>