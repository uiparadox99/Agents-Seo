<template>
	<div>
		<div class="alert alert-success alert-dismissible fade in" role="alert" v-if="$parent.$parent.success_message != ''">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&#10006;</span>
			</button>
			<span v-html="$parent.$parent.success_message"></span>
		</div>
		<div class="alert alert-danger alert-dismissible fade in" role="alert" v-if="$parent.$parent.error_message != ''">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&#10006;</span>
			</button>
			<span v-html="$parent.$parent.error_message"></span>
		</div>
	</div>
</template>
<script>
export default {
	beforeMount(){
		var $this = this;
		setTimeout(function() {
			$this.$parent.$parent.error_message = "";
			$this.$parent.$parent.success_message = "";
		}, 5000);
	}
}
</script>