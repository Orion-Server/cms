import Alpine from "alpinejs"
import Turbolinks from "turbolinks"
import XssWrapper from "../../external/XssWrapper"

class AutomaticSearch {
    start() {
        document.addEventListener("alpine:init", this._startComponent)
    }

    _startComponent() {
        Alpine.data("automaticSearch", (endpoint) => ({
            search: '',
            endpoint,

            init() {
                this.treatSearchFromUrl()

                if(this.search.length > 0) {
                    this.$refs.search.focus()
                }

                this.$watch('search', Alpine.debounce(() => {
                    if (this.search.length <= 0) {
                        Turbolinks.visit(this.endpoint)
                        return
                    }

                    Turbolinks.visit(`${this.endpoint}?search=${this.search}`)
                }, 700));
            },

            treatSearchFromUrl() {
                const urlParams = new URLSearchParams(window.location.search)
                const search = urlParams.get('search')

                if (search) {
                    this.search = XssWrapper.clean(search)
                }
            }
        }))
    }
}

export default new AutomaticSearch()
