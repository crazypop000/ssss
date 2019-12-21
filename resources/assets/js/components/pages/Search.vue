<template>
	<div class="container">
		<div class="search">
			<div class="search-container">
				<div class="content-header">
					<h2 class="title is-2 text-title">Laravel Scout with Algolia Search Engine</h2>
				</div>
				<div class="input-search">
					<b-field>
			            <b-input placeholder="Search..."
			                type="search"
			                icon="magnify"
			                v-model="txt_search"
			                @keyup.native.enter="searchUser">
			            </b-input>
			        </b-field>
				</div>
				<div class="table-user">
					<b-table
			            :data="list_users"
			            :loading="loading"
			            paginated
			            backend-pagination
			            :total="pagination.last_page"
			            :per-page="pagination.per_page"
				        @page-change="onPageChange">

			            <template slot-scope="props">
			                <b-table-column field="id" label="ID" sortable>
			                    {{ props.row.id }}
			                </b-table-column>

			                <b-table-column field="name" label="Name">
		                        {{ props.row.name }}
			                </b-table-column>

			                <b-table-column field="email" label="Email">
			                     {{ props.row.email }}
			                </b-table-column>

			                <b-table-column field="created_at" label="Created At">
			                    {{ props.row.created_at }}
			                </b-table-column>
			            </template>
			        </b-table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				loading: false,
				list_users: [],
				pagination: {
                    current_page: 1,
                    per_page: 10,
                    last_page: 1
			    },
			    txt_search: ''
			}
		},
		created() {
			this.getUsers()
		},
		methods: {
			getUsers(page = 1) {
				this.loading = true
				axios.get('/getUsers?page=' + page)
				.then(response => {
					this.list_users = response.data.data
                    this.pagination.current_page = response.data.current_page
                    this.pagination.per_page = response.data.per_page
                    this.pagination.last_page = response.data.last_page
                    this.loading = false
				})
				.catch(error => {
					console.log(error)
					this.loading = false
				})
			},
			onPageChange(page) {
				this.getUsers(page)
			},
			searchUser() {
				axios.post('/searchUser', {search: this.txt_search})
				.then(response => {
					console.log(response.data)
					
				})
				.catch(error => {
					console.log(error)
				})
			}
		}
	}
</script>

<style lang="scss" scoped>
.search {
	.search-container {
	    padding-top: 30px;
	    .content-header {
	    	.text-title {
	    		font-weight: 300;
				text-align: center;
	    	}
	    }
	    .input-search {
	    	margin-top: 30px;
	    }
	    .table-user {
	    	margin-top: 30px;
	    }
	}
}
</style>