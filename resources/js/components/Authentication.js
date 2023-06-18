import axios from 'axios'
import Alpine from 'alpinejs'

export default class Authentication {
    static start() {
        document.addEventListener('alpine:init', () => Authentication._startComponent())
    }

    static _startComponent() {
        Alpine.data('authentication', () => ({
            showLoginModal: false,
            showRegisterModal: false,
            loading: false,

            init() {
                this.$nextTick(() => this.treatCurrentUrl())
            },

            ...Authentication._layoutMethods(),
            ...Authentication._registerFormMethods(),
            ...Authentication._loginFormMethods(),
        }))
    }

    static _layoutMethods() {
        return {
            treatCurrentUrl() {
                const url = new URL(window.location.href)

                if (['/login'].includes(url.pathname)) {
                    this.toggleToLoginModal()
                }

                if (['/register'].includes(url.pathname)) {
                    this.toggleToRegisterModal(
                        url.searchParams.get('referral')
                    )
                }
            },

            toggleToRegisterModal(referralCode = null) {
                this.showLoginModal = false
                this.showRegisterModal = true

                if(referralCode) {
                    this.treatReferralCode(referralCode)
                }
            },

            toggleToLoginModal() {
                console.log('entrei')
                this.showRegisterModal = false
                this.showLoginModal = true
            },

            treatReferralCode(referralCode) {
                this.registerReferrerData.code = referralCode

                const referralUsername = localStorage.getItem(`referral_${referralCode}_username`)

                if(referralUsername) {
                    this.registerReferrerData.username = referralUsername
                    return
                }

                axios.get(`/api/referral/${referralCode}`)
                    .then(response => {
                        if(response.status != 200) return

                        this.registerReferrerData.username = response.data.username

                        localStorage.setItem(`referral_${referralCode}_username`, response.data.username)
                    })
                    .catch(error => {
                        console.error('[ReferralIdentification] - ', error)
                    })
            }
        }
    }

    static _registerFormMethods() {
        return {
            registerData: {
                username: '',
                email: '',
                password: '',
                password_confirmation: '',
                gender: 'M',
            },

            registerReferrerData: {
                code: null,
                username: null
            },

            async onFormRegisterSubmit() {
                if(this.loading) return

                this.loading = true

                if(this.registerReferrerData.code) {
                    this.registerData.referrer_code = this.registerReferrerData.code
                }

                const recaptchaResponse = document.querySelector('#register-form #g-recaptcha-response')

                if(recaptchaResponse && recaptchaResponse.value.length) {
                    this.registerData.recaptcha = recaptchaResponse.value
                }

                await Authentication._attemptAuthentication('/register', this.registerData,
                    () => {
                        Authentication._treatResponseSuccess(this, 'You have been registered successfully.')
                    },
                    (response) => {
                        Authentication._treatResponseErrors(this, response)
                    },
                    () => {
                        this.$dispatch('orion:alert', {
                            message: 'Please fill in all register fields',
                            type: 'error'
                        })
                    }
                )

                setTimeout(() => this.loading = false, 2000)
            }
        }
    }

    static _loginFormMethods() {
        return {
            loginData: {
                username: '',
                password: ''
            },

            async onFormLoginSubmit() {
                if(this.loading) return

                this.loading = true

                await Authentication._attemptAuthentication('/login', this.loginData,
                    () => {
                        Authentication._treatResponseSuccess(this, 'You have been logged in successfully.')
                    },
                    (response) => {
                        Authentication._treatResponseErrors(this, response)
                    },
                    () => {
                        this.$dispatch('orion:alert', {
                            message: 'Please fill in all login fields',
                            type: 'error'
                        })
                    }
                )

                setTimeout(() => this.loading = false, 2000)
            }
        }
    }

    static async _attemptAuthentication(url, formData, onSuccessCallback, onFailureCallback, onInvalidFieldsCallback = null) {
        Authentication._validateFields(formData)
            .then(async () => {
                this.loading = true

                await axios.post(url, formData).then(response => {
                        onSuccessCallback(response)
                    })
                    .catch(({ response }) => {
                        onFailureCallback(response)
                    })
            })
            .catch(() => {
                onInvalidFieldsCallback()
            })
    }

    static _validateFields(formData) {
        return new Promise((resolve, reject) => {
            const validFields = Object.values(formData).filter(field => !! field)

            if(validFields.length === Object.keys(formData).length) resolve(true)
            else reject(false)
        })
    }

    static _treatResponseErrors(componentInstance, response) {
        const errors = response.data.errors

        if (!errors || !Object.keys(errors).length) return

        Object.values(errors)
            .at(0)
            .forEach(message => {
                componentInstance.$dispatch('orion:alert', {
                    message,
                    type: 'error'
                })
            })
    }

    static _treatResponseSuccess(componentInstance, message, redirectToHome = true) {
        componentInstance.$dispatch('orion:alert', {
            message,
            type: 'success'
        })

        if(!redirectToHome) return

        setTimeout(() => {
            window.location.href = '/'
        }, 1500)
    }
}
