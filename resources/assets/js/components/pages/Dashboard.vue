<template>
	<MainLayout>
		<div class="dashboard">
			<div class="dashboard-container">
				<div class="dashboard-main-content">
					<div class="content-header">
						<div class="title">
							<h2>
								Welcome to our bakery
							</h2>
							<a href="/send" class="btn btn-default">Send Email</a>
							<input type="file" name=""  @change="onFileChange">
						</div>
					</div>
					<div class="content-body">
						<img src="/images/bread.jpg">
					</div>
				</div>
			</div>
		</div>
	</MainLayout>
</template>

<script>
	export default {
		created() {
			Echo.channel('message-posted')
		    .listen('MessagePosted', (data) => {
		        console.log(data)
		    })
		},
		methods: {
			onFileChange(e) {
				console.log(e.target.files)
			}
		}
	}
</script>

<style lang="scss" scoped>
	.dashboard {
		.dashboard-container {
			.header {
			    border-bottom: solid 1px #ddd;
			    padding-bottom: 10px;
			}
			.dashboard-main-content {
				padding: 25px;
				.content-header {
					display: flex;
					.title {
						flex: 5;
					}
				}
				.content-body {
					margin-top: 20px;
				}
			}
		}
	}
</style>