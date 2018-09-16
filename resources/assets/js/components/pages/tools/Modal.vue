<template>
	<div>
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">Thêm nguyên liệu</p>
            </header>
            <section class="modal-card-body">
            	<b-field label="Tên dụng cụ">
                    <b-input
                        type="text"
                        v-model="tool.name"
                        minlength="3"
                        :has-counter="false"
                        required>
                    </b-input>
                </b-field>

                <b-field label="Số lượng">
                    <b-input
                        type="number"
                        v-model="tool.quantity"
                        required>
                    </b-input>
                </b-field>

                <b-field label="Mô tả">
                    <b-input
                        v-model="tool.description"
                        required>
                    </b-input>
                </b-field>
            </section>
            
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Đóng</button>
                <button class="button is-primary" @click="createTool()">Xong</button>
            </footer>
        </div>
	</div>
</template>

<script>
	export default {
		props: ['type'],
		data() {
			return {
				tool: {
					name: '',
					quantity: 0,
					description: '',
					user_id: this.$root.currentUser.id,
				},
				error: ''
			}
		},
		methods: {
			createTool() {
				axios.post('/tools', {tool: this.tool})
				.then(response => {
					this.$emit('finishCreate')
				})
				.catch(error => {
					console.log(error)
				})
			}
		}
	}
</script>

<style lang="scss" scoped>
.error-text {
	color: red;
}
</style>