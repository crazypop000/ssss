<template>
	<MainLayout>
		<div class="user-management">
			<div class="user-management-container">
				<div class="user-management-main-content">
					<div class="content-header">
						<div class="title">
							<h2>
								User management
							</h2>
						</div>
					</div>
					<div class="content-body">
						<div class="form-add-user">
							<button class="button is-primary is-pulled-right" @click="showModal('create')">Create</button>
						</div>
						<b-modal :active.sync="isComponentModalActive" has-modal-card>
				            <Modal :type="currentModelType" @finishCreate="finishCreate"></Modal>
				        </b-modal>
						
						<div class="table-users">
							<b-table :data="list_users">
								<template slot-scope="props">
					                <b-table-column field="id" label="ID" width="40" numeric centered>
					                    {{ props.row.id }}
					                </b-table-column>
					                <b-table-column field="name" label="Name" centered>
					                	<div v-if="!props.row.isEdit">
						                    <b>{{ props.row.name }}</b>
						                    <span v-if="props.row.id === $root.currentUser.id">(Current)</span>
						                </div>
						                <div v-else>
						                	<b-field>
									            <b-input v-model="props.row.name" minlength="3"></b-input>
									        </b-field>
						                </div>
					                </b-table-column>
					                <b-table-column field="email" label="Email" centered>
					                	<div v-if="!props.row.isEdit">
					                		{{ props.row.email }}
					                	</div>
					                	<div v-else>
					                		<b-field>
									            <b-input v-model="props.row.email" type="email"></b-input>
									        </b-field>
					                	</div>
					                </b-table-column>
					                <b-table-column field="role" label="Role" centered>
					                	<div v-if="!props.row.isEdit">
					                		{{ props.row.roles[0].name }}
					                	</div>
					                	<div v-else style="text-align: center;">
					                		<b-field>
									            <b-select style="text-align: center;" placeholder="Select a role" v-model="props.row.roles[0].name">
									                <option value="employee">Employee</option>
									                <option value="baker">Baker</option>
									                <option value="admin">Admin</option>
									            </b-select>
									        </b-field>
					                	</div>
					                </b-table-column>
					                <b-table-column label="Actions" centered>
					                	<div v-if="!props.row.isEdit">
						                   	<button class="button is-success is-outlined is-small" @click="editUser(props.row)">Edit</button>
						                   	<button class="button is-danger is-outlined is-small">Delete</button>
					                   </div>
					                   <div v-else>
						                   	<button class="button is-success is-outlined is-small" @click="saveUser(props.row)">Save</button>
						                   	<button class="button is-danger is-outlined is-small" @click="cancelEdit(props.row)">Cancel</button>
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
				list_users: [],
				currentModelType: '',
				isComponentModalActive: false,
				oldUser: {}
			}
		},
		created() {
			this.getListUsers()
		},
		methods: {
			getListUsers() {
				this.$http.get('/users')
				.then(response => {
					this.list_users = response.body
					this.list_users.forEach(user => {
						Vue.set(user, 'isEdit', false)
					})
				}, error => {
					console.log(error)
				})
			},
			showModal(type) {
				this.isComponentModalActive = true
				this.currentModelType = type
			},
			finishCreate() {
				this.isComponentModalActive = false
				this.currentModelType = ''
				this.getListUsers()
			},
			editUser(user) {
				user.isEdit = true
				this.oldUser = _.cloneDeep(user)
			},
			cancelEdit(user) {
				user.name = this.oldUser.name
				user.email = this.oldUser.email
				user.roles[0].name = this.oldUser.roles[0].name
				user.isEdit = false
				this.oldUser = {}
				console.log(user)
				this.$forceUpdate()
			},
			saveUser(user) {
				axios.post('/editUser', {user: user})
				.then(response => {
					console.log(response)
					user.isEdit = false
				})
				.catch(error => {
					console.log(error)
				})
			}
		}
	}
</script>

<style lang="scss" scoped>
	.user-management {
		.user-management-container {
			.header {
			    border-bottom: solid 1px #ddd;
			    padding-bottom: 10px;
			}
			.user-management-main-content {
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