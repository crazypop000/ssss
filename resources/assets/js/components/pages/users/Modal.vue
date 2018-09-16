<template>
	<div>
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ type == 'create' ? 'Create' : 'Edit' }} User</p>
            </header>
            <section class="modal-card-body">
            	<b-field label="Name">
                    <b-input
                        type="text"
                        v-model="user.name"
                        placeholder="Your name"
                        minlength="3"
                        :has-counter="false"
                        required>
                    </b-input>
                </b-field>

                <b-field label="Email">
                    <b-input
                        type="email"
                        v-model="user.email"
                        placeholder="Your email"
                        required>
                    </b-input>
                </b-field>

                <b-field label="Password">
                    <b-input
                        type="password"
                        v-model="user.password"
                        password-reveal
                        placeholder="Your password"
                        required>
                    </b-input>
                </b-field>

                <b-field label="Confirm password">
                    <b-input
                        type="password"
                        v-model="user.confirmPassword"
                        password-reveal
                        placeholder="Your confirm password"
                        required>
                    </b-input>
                </b-field>

                <b-field label="Role">
		            <b-select placeholder="Select a role" v-model="user.role">
		                <option value="employee">Employee</option>
		                <option value="baker">Baker</option>
		                <option value="admin">Admin</option>
		            </b-select>
		        </b-field>
                <div class="error-text" v-if="error.length">
					{{ error }}
	            </div>
            </section>
            
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
                <button class="button is-primary" @click="createUser()">Done</button>
            </footer>
        </div>
	</div>
</template>

<script>
	export default {
		props: ['type'],
		data() {
			return {
				user: {
					name: '',
					email: '',
					password: '',
					confirmPassword: '',
					role: ''
				},
				error: ''
			}
		},
		methods: {
			createUser() {
				if(this.user.password !== this.user.confirmPassword) {
					this.error = 'Please check again your password'
				}
				else {
					axios.post('/users', {user: this.user})
					.then(response => {
						this.$emit('finishCreate')
					})
					.catch(error => {
						console.log(error)
					})
				}
			}
		}
	}
</script>

<style lang="scss" scoped>
.error-text {
	color: red;
}
</style>