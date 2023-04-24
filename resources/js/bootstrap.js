import axios from 'axios'
import Alpine from 'alpinejs'

window.Alpine = Alpine
window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
Alpine.start()
