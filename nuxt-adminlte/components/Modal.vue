<template>
	<div :id="id" class="modal fade" role="dialog">
		<div
			:class="{
            'modal-dialog': true,  
            'modal-lg': size === 'large',
            'modal-sm': size === 'small',
            }"
			role="document"
		>
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{{title}}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<slot name="body">...</slot>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button v-if="enableSubmitBtn" type="button" class="btn btn-primary" :class="{'btn-loading': loading}" :disabled="loading" @click="submitFn">{{submitValue}}</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</template>
<script>
export default {
    name: 'Modal',

	props: {
        id: {
            type: String,
        },

		title: {
			type: String,
			default: ""
		},

		size: {
			type: String,
			default: ""
		},

		submitValue: {
			type: String,
			default: "Submit"
        },
        
        submitFn: {
            type: Function
		},
		
		loading: {
			type: Boolean,
			default: false
		},

		enableSubmitBtn: {
			type: Boolean,
			default: true
		}
    },

    // destroyed(){
    //     console.log('DESTROY MODAL...');
        
    // }

    // mounted(){
    //     this.$nextTick(function () {
    //         // Code that will run only after the
    //         // entire view has been rendered
    //         $(this.$el).modal('toggle');
    //     })
    // }
};
</script>