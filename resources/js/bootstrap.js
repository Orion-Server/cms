import axios from 'axios'
import 'alpine-turbo-drive-adapter'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

import Turbolinks from "turbolinks"

Turbolinks.start()

