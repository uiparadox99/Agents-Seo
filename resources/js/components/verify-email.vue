<template>
	<div>
			<VGHeader></VGHeader>
			<ContentLoader >
				<rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
				<rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
				<rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
				<rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
				<rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
				<rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
			</ContentLoader>
			<VFooter></VFooter>
		</div>
	</template>
	<script>
	export default {
		data (){
			return {
			}

		},
		beforeMount(){
			this.getData();
		},
		methods: {
			getData(){
				console.log(this.$route.query.token);
				if (typeof this.$route.query.token !== 'undefined' && this.$route.query.token != '') {
					var dataUrl = 'v1/verify-account/';
					axios({ method: "POST", "url":dataUrl,"data":{'code':this.$route.query.token}, "headers": { "content-type": "application/json" } }).then(result => {
						var response = result.data;
						if (response.status) {
							this.$parent.success_message = 'Account Verified Successfully!';       
							this.$router.push({path: '/login'});
						}else{
							this.$parent.error_message = 'Verification code is not valid!';       
							this.$router.push({path: '/login'});
						}

					}, error => {

					});
				}        
			}
		}
	}
	</script>