<template>
	<div>
        <div class="modal-card" style="width: 500px">
            <header class="modal-card-head">
                <p class="modal-card-title">Xuất nguyên liệu</p>
            </header>
            <section class="modal-card-body">
                <b-field label="Số lượng">
                    <b-input
                        type="number"
                        v-model="quantity"
                        required>
                    </b-input>
                </b-field>
                <div class="error-text" v-if="error.length">
                	{{ error }}
                </div>
            </section>
            
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Đóng</button>
                <button class="button is-primary" @click="exportMaterial()">Xong</button>
            </footer>
        </div>
	</div>
</template>

<script>
	export default {
		props: ['currentSelectedMaterial'],
		data() {
			return {
				quantity: 0,
				error: ''
			}
		},
		methods: {
			exportMaterial() {
				if(this.quantity > this.currentSelectedMaterial.quantity) {
					this.error = 'Quá số lượng nguyên liệu sẵn có'
				}
				else {
					this.$emit('finishExport', this.quantity)
					this.error = ''
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