import axios from 'axios'
import Alpine from 'alpinejs'

class Photos {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('photosPage', () => ({
            loading: false,
            activeFilter: 'all',

            init() {

            },
        }))
    }
}

export default new Photos
