<template>
	<div>
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">Thêm nguyên liệu</p>
            </header>
            <section class="modal-card-body">
            	<b-field label="Tên nguyên liệu">
                    <b-input
                        type="text"
                        v-model="material.name"
                        minlength="3"
                        :has-counter="false"
                        required>
                    </b-input>
                </b-field>

                <b-field label="Số lượng">
                    <b-input
                        type="number"
                        v-model="material.quantity"
                        required>
                    </b-input>
                </b-field>
            </section>
            
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Đóng</button>
                <button class="button is-primary" @click="createMaterial()">Xong</button>
            </footer>
        </div>
	</div>
</template>

<script>
	export default {
		props: ['type'],
		data() {
			return {
				material: {
					name: '',
					quantity: '0',
					user_id: this.$root.currentUser.id,
				},
				error: ''
			}
		},
		methods: {
			createMaterial() {
				axios.post('/createMaterials', {material: this.material})
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