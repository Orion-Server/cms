import axios from "axios";
import "alpine-turbo-drive-adapter";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Turbolinks from "turbolinks";

Turbolinks.start();

let scrollTop = null

document.addEventListener('turbolinks:before-visit', event => {
    const hasScrollableElements = !! document.querySelector('[data-turbolinks-scroll]')

    if(!hasScrollableElements) return

    scrollTop = event.target?.scrollingElement?.scrollTop
})

document.addEventListener('turbolinks:render', event => {
    if(!scrollTop) return

    document.scrollingElement?.scrollTo(0, scrollTop)
})

