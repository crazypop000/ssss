<template>
	<MainLayout>
		<div class="tools">
			<div class="tools-container">
				<div class="tools-main-content">
					<div class="content-header">
						<div class="title">
							<h2>
								Dụng cụ nhà bếp
							</h2>
						</div>
					</div>
					<div class="content-body">
						<div class="form-add-user">
							<button class="button is-primary is-pulled-right" @click="isComponentModalActive = true">Thêm mới</button>
						</div>
						<b-modal :active.sync="isComponentModalActive" has-modal-card>
				            <Modal @finishCreate="finishCreate"></Modal>
				        </b-modal>
						
						<div class="table-users">
							<b-table :data="tools">
								<template slot-scope="props">
					                <b-table-column field="id" label="ID" width="40" numeric centered>
					                    {{ props.row.id }}
					                </b-table-column>
					                <b-table-column field="name" label="Tên dụng cụ" centered>
					                	<div v-if="!props.row.isEdit">
						                    {{ props.row.name }}
						                </div>
						                <div v-else>
						                	<b-field>
									            <b-input v-model="props.row.name" minlength="3"></b-input>
									        </b-field>
						                </div>
					                </b-table-column>
					                <b-table-column field="quantity" label="Số lượng" centered>
					                	<div v-if="!props.row.isEdit">
						                    {{ props.row.quantity }}
						                </div>
						                <div v-else>
						                	<b-field>
									            <b-input v-model="props.row.quantity" type="number"></b-input>
									        </b-field>
						                </div>
					                </b-table-column>
					                <b-table-column field="user_name" label="Người tạo" centered>
				                		<b>{{ props.row.user.name }}</b>
					                </b-table-column>
					                <b-table-column label="Actions" centered>
					                	<div v-if="!props.row.isEdit">
						                   	<button class="button is-success is-outlined is-small" @click="editTool(props.row)">Sửa</button>
						                   	<button class="button is-danger is-outlined is-small" @click="deleteTool(props.row)">Xoá</button>
					                   </div>
					                   <div v-else>
						                   	<button class="button is-info is-outlined is-small" @click="saveTool(props.row)">Lưu</button>
						                   	<button class="button is-danger is-outlined is-small" @click="cancelEdit(props.row)">Huỷ</button>
					                   </div>
					                </b-table-column>
					            </template>

					            <template slot="empty">
					                <section class="section">
					                    <div class="content has-text-grey has-text-centered">
					                        <p>
					                            <b-icon
					                                icon="emoticon-sad"
					                                size="is-large">
					                            </b-icon>
					                        </p>
					                        <p>Bạn chưa có dụng cụ nào.</p>
					                    </div>
					                </section>
					            </template>
							</b-table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</MainLayout>
</template>

<script>
	import Modal from './Modal.vue'
	export default {
		components: {
			Modal
		},
		data() {
			return {
				isComponentModalActive: false,
				tools: []
			}
		},
		created() {
			this.getTools()
		},
		methods: {
			getTools() {
				axios.get('/getAllTools')
				.then(response => {
					this.tools = response.data
					this.tools.forEach(tool => {
						Vue.set(tool, 'isEdit', false)
					})
				})
				.catch(error => {
					console.log(error)
				})
			},
			finishCreate() {
				this.isComponentModalActive = false
				this.getTools()
			},
			editTool(tool) {
				tool.isEdit = true
			},
			cancelEdit(tool) {
				tool.isEdit = false
			},
			saveTool(tool) {
				axios.post('/updateTool', {tool: tool})
				.then(response => {
					this.getTools()
				})
				.catch(error => {
					console.log(error)
				})
			},
			deleteTool(tool) {
				this.$dialog.confirm({
                    title: 'Error',
                    message: `Bạn có chắc chắn muốn xoá dụng cụ <b>${tool.name}</b> này`,
                    type: 'is-danger',
                    hasIcon: true,
                    icon: 'times-circle',
                    iconPack: 'fa',
                    cancelText: 'Huỷ',
                    confirmText: 'Đồng ý',
                    onConfirm: () => {
                    	axios.post('/deleteTool', {tool: tool})
						.then(response => {
							this.getTools()
						})
						.catch(error => {
							console.log(error)
						})
                    }
                })
			}		
		}
	}
</script>

<style lang="scss" scoped>
	.tools {
		.tools-container {
			.header {
			    border-bottom: solid 1px #ddd;
			    padding-bottom: 10px;
			}
			.tools-main-content {
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