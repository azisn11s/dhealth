<template>
	<div class="small-box" :class="`bg-${color}`">
		<div class="inner">
            <vue-element-loading
                :active="isLoading"
                :is-full-screen="false"
            />
			<slot>My Box Content</slot>
		</div>
		<div class="icon">
            <i class="fa" :class="`${faIcon}`"></i>
        </div>
		<nuxt-link tag="a" :to="url" class="small-box-footer" v-if="url">
            More info 
            <i class="fas fa-arrow-circle-right"></i>
        </nuxt-link>
	</div>
</template>

<script>
export default {

    name: "MyBox",
    
    props: {
        color: {
            type: String,
            default: "info"
        },

        icon: {
            type: String,
            default: ""
        },

        url: {
            type: Object,
            default: null
        },

        isLoading: {
            type: Boolean,
            default: false
        }
    },
    
    data(){
        return {}
    },

    computed: {
        faIcon(){
            if (!this.icon) {
                return '';
            }

            return `fa-${this.icon}`;
        }
    }


};
</script>

<style>
</style>