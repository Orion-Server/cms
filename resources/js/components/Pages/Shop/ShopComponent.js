import XssWrapper from "../../../external/XssWrapper"

export default new class ShopComponent {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('shopComponent', (buyProductEndpoint) => ({
            modalOpen: false,
            loadingId: null,
            product: null,

            getProductOrderEndpoint(productId) {
                return buyProductEndpoint.replace('%ID%', productId)
            },

            openProductModal(id) {
                this.loadingId = id

                axios.get(`/api/shop/products/${id}`).then(response => {
                    if(!response.data.success) {
                        this.$dispatch('orion:alert', { type: 'error', message: data?.message || __('Failed to fetch the product.') })
                        return
                    }

                    this.loadingId = null
                    this.product = response.data.product
                    this.product.content = XssWrapper.clean(this.product.content)

                    setTimeout(() => this.modalOpen = true, 500)
                }).catch(error => {
                    console.error('[ShopComponent] - ', error)
                })
            }
        }))
    }
}
