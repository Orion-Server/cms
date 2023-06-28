import axios from 'axios'
import Alpine from 'alpinejs'

class UserProfileComponent {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('userProfile', () => ({
            editing: false
        }))
    }
}

export default new UserProfileComponent
