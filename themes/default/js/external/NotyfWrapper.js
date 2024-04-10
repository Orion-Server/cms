import { Notyf } from 'notyf'

export default class Alert {
    alert
    message
    duration

    constructor() {
        if(typeof window === 'undefined') return

        this.alert = new Notyf({
            duration: 4000,
            position: {
                x: 'right',
                y: 'top',
            },
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    icon: false
                },
                {
                    type: 'info',
                    background: '#0284c7',
                    icon: '<i class="fa-solid fa-circle-info"></i>'
                }
            ]
        })
    }

    static success(message, duration) {
        return new Alert()._success(message, duration)
    }

    static warning(message, duration) {
        return new Alert()._warning(message, duration)
    }

    static info(message, duration) {
        return new Alert()._info(message, duration)
    }

    static error(message, duration) {
        return new Alert()._error(message, duration)
    }

    static alert(type, message, duration) {
        switch(type) {
            case 'success':
                this.success(message, duration)
                break
            case 'warning':
                this.warning(message, duration)
                break
            case 'info':
                this.info(message, duration)
                break
            case 'error':
                this.error(message, duration)
                break
        }
    }

    _success(message, duration) {
        if(!this.alert) return

        return this.alert.success({ message, duration })
    }

    _warning(message, duration) {
        if(!this.alert) return

        return this.alert.open({
            type: 'warning',
            message,
            duration
        })
    }

    _info(message, duration) {
        if(!this.alert) return

        return this.alert.open({
            type: 'info',
            message,
            duration
        })
    }

    _error(message, duration) {
        if(!this.alert) return

        return this.alert.error({ message, duration })
    }
}
