<template>
	<MainLayout>
		<div class="materials">
			<div class="materials-container">
				<div class="materials-main-content">
					<div class="content-header">
						<div class="title">
							<h2>
								Nguyên liệu
							</h2>
						</div>
					</div>
					<div class="content-body">
						<div v-if="$root.currentUser.roles">
							<button v-if="$root.currentUser.roles[0].id === 3 || $root.currentUser.roles[0].id === 2" class="button is-primary is-pulled-right" @click="isComponentModalActive = true">Nhập nguyên liệu</button>
						</div>
						<b-modal :active.sync="isComponentModalActive" has-modal-card>
				            <Modal @finishCreate="finishCreate"></Modal>
				        </b-modal>
				        <b-modal :active.sync="isModalExportActive" has-modal-card>
				            <ModalExport :currentSelectedMaterial="currentSelectedMaterial" @finishExport="finishExport"></ModalExport>
				        </b-modal>
						<div class="table-users">
							<b-table :data="materials">
								<template slot-scope="props">
					                <b-table-column field="id" label="ID" width="40" numeric centered>
					                    {{ props.row.id }}
					                </b-table-column>
					                <b-table-column field="name" label="Tên nguyên liệu" centered>
					                	<div v-if="!props.row.isEdit">
						                    <b>{{ props.row.name }}</b>
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
									            <b-input v-model="props.row.quantity" type="text"></b-input>
									        </b-field>
					                	</div>
					                </b-table-column>
					                <b-table-column field="user_id" label="Người nhập" centered>
					                	<div>
					                		{{ props.row.user.name }}
					                	</div>
					                </b-table-column>
					                <b-table-column label="Actions" centered>
					                	<div v-if="!props.row.isEdit && $root.currentUser.roles">
					                		<button class="button is-info is-outlined is-small" @click="selectMaterial(props.row)" v-if="$root.currentUser.roles[0].id === 1 || $root.currentUser.roles[0].id === 2">Xuất hàng</button>
						                   	<button class="button is-success is-outlined is-small" @click="editMaterial(props.row)" v-if="$root.currentUser.roles[0].id === 3 || $root.currentUser.roles[0].id === 2">Sửa</button>
						                   	<button class="button is-danger is-outlined is-small" v-if="$root.currentUser.roles[0].id === 3 || $root.currentUser.roles[0].id === 2" @click="deleteMaterial(props.row)">Xoá</button>
					                   </div>
					                   <div v-else>
						                   	<button class="button is-success is-outlined is-small" @click="saveMaterial(props.row)">Lưu</button>
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
					                        <p>Nothing here.</p>
					                    </div>
					                </section>
					            </template>
							</b-table>
						</div>
						<hr>
						<div class="columns is-multiline" v-if="$root.currentUser.roles">
							<div class="column is-12">
								<h2 class="title is-3">Lịch sử</h2>
							</div>
							<div class="column is-12">
								<b-table :data="history">
									<template slot-scope="props">
						                <b-table-column field="id" label="ID" width="40" numeric centered sortable>
						                    {{ props.row.id }}
						                </b-table-column>
						                <b-table-column field="type" label="Loại" centered>
							                {{ props.row.type == 'import' ? 'Nhập hàng' : 'Xuất hàng' }}
						                </b-table-column>
						                <b-table-column field="action" label="Hành động" centered>
							                {{ props.row.action }}
						                </b-table-column>
						                <b-table-column field="type" label="Người thực hiện" centered>
							                <b>{{ props.row.user.name}}</b>
						                </b-table-column>
						                <b-table-column field="description" label="Chi tiết" centered width="500">
							                <span v-html="props.row.description"></span>
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
						                        <p>Bạn chưa có nguyên liệu nào.</p>
						                    </div>
						                </section>
						            </template>
								</b-table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</MainLayout>
</template>

<script>
	import Modal from './Modal.vue'
	import ModalExport from './ModalExport.vue'
	export default {
		components: {
			Modal,
			ModalExport
		},
		data() {
			return {
				materials: [],
				history: [],
				isComponentModalActive: false,
				currentSelectedMaterial: {},
				isModalExportActive: false
			}
		},
		created() {
			this.getMaterials()
			this.getHistory()
		},
		methods: {
			getHistory() {
				axios.get('/historyImportExport')
				.then(response => {
					this.history = response.data
					this.history.forEach(item => {
						if(item.action === 'create') {
							item.action = 'Thêm mới'
						}
						else if(item.action === 'edit') {
							item.action = 'Chỉnh sửa'
						}
						else if(item.action === 'delete') {
							item.action = 'Xoá'
						}
						else if(item.action === 'export') {
							item.action = 'Xuất hàng'
						}
					})
				})
				.catch(error => {
					console.log(error)
				})
			},
			getMaterials() {
				axios.get('/getMaterials')
				.then(response => {
					this.materials = response.data
					this.materials.forEach(material => {
						Vue.set(material, 'isEdit', false)
					})
				})
				.catch(error => {
					console.log(error)
				})
			},
			finishCreate() {
				this.isComponentModalActive = false
				this.getMaterials()
			},
			editMaterial(material) {
				material.isEdit = true
			},
			cancelEdit(material) {
				material.isEdit = false
			},
			saveMaterial(material) {
				axios.post('editMaterials', {material: material})
				.then(response => {
					this.getMaterials()
				})
				.catch(error => {
					console.log(error)
				})
			},
			selectMaterial(material) {
				this.isModalExportActive = true
				this.currentSelectedMaterial = material
			},
			finishExport(quantity) {
				axios.post('/exportMaterial', {material: this.currentSelectedMaterial, quantity: quantity})
				.then(response => {
					this.getMaterials()
					this.getHistory()
				})
				.catch(error => {
					console.log(error)
				})
				this.isModalExportActive = false
			},
			deleteMaterial(material) {
				this.$dialog.confirm({
                    title: 'Error',
                    message: 'Bạn có chắc chắn muốn xoá nguyên liệu này',
                    type: 'is-danger',
                    hasIcon: true,
                    icon: 'times-circle',
                    iconPack: 'fa',
                    cancelText: 'Huỷ',
                    confirmText: 'Đồng ý',
                    onConfirm: () => {
                    	axios.post('/deleteMaterial', {material: material})
						.then(reponse => {
							this.getMaterials()
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
	.materials {
		.materials-container {
			.header {
			    border-bottom: solid 1px #ddd;
			    padding-bottom: 10px;
			}
			.materials-main-content {
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