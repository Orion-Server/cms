import Alpine from 'alpinejs'
import DOMPurify from 'dompurify'

export default new class AlpineHelpers {
    start() {
        this.initSanitize()
    }

    initSanitize() {
        Alpine.magic('sanitize', () => {
            return html => DOMPurify.sanitize(html)
        })
    }
}
