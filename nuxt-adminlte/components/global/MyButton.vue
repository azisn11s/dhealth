<template>
	<button
		:type="nativeType"
		:disabled="loading"
		:class="{
			[`btn-${type}`]: true,
			'btn-block': block,
			'btn-lg': large,
		}"
		class="btn"
	>
        <span v-if="loading" class="spinner-border spinner-border-sm mb-1" role="status" aria-hidden="true"></span>
		<slot />
	</button>
</template>

<script>
export default {
	name: "MyButton",

	props: {
		type: {
			type: String,
			default: "info",
		},

		nativeType: {
			type: String,
			default: "submit",
		},

		loading: {
			type: Boolean,
			default: false,
		},

		block: {
			type: Boolean,
			default: false,
		},

		large: {
			type: Boolean,
			default: false,
		},
	},
};
</script>
