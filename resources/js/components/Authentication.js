import axios from 'axios'
import Alpine from 'alpinejs'

export default class Authentication {
    static start() {
        document.addEventListener('alpine:init', () => Authentication._startComponent())
    }

    static _startComponent() {
        Alpine.data('authentication', (figureUrl = '') => ({
            showLoginModal: false,
            showRegisterModal: false,
            loading: false,
            figureUrl,

            init() {
                this.$nextTick(() => this.treatCurrentUrl())

                if(this.figureUrl.length) this.setupAvatarPreview()
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
                    this.treatReferralCode(url.searchParams.get('referral'))
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
                this.showRegisterModal = false
                this.showLoginModal = true
            },

            treatReferralCode(referralCode) {
                if(!referralCode) return

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
                birthday: ''
            },

            registerStaticData: {
                defaultLooks: []
            },

            registerReferrerData: {
                code: null,
                username: null
            },

            setupAvatarPreview() {
                this.registerStaticData.defaultLooks = registerLooks

                this.registerData.look = this.registerStaticData.defaultLooks[this.registerData.gender][0] || ''

                this.$watch('registerData.gender', (newValue, oldValue) => {
                    if(!['M', 'F'].includes(newValue) || newValue === oldValue) return

                    if(!this.registerStaticData.defaultLooks[newValue]) return

                    this.registerData.look = this.registerStaticData.defaultLooks[newValue][0]
                })
            },

            getDefaultLooksByGender() {
                return this.registerStaticData.defaultLooks[this.registerData.gender] || []
            },

            getFigureUrl(look) {
                return this.figureUrl.replace('%figure%', look).replace('%params%', 'direction=3&head_direction=3&gesture=sml&action=wav&size=m')
            },

            genderSelectedIs(gender) {
                return this.registerData.gender === gender
            },

            lookIsActiveByGender(gender, look) {
                return this.registerData.look === look && this.registerData.gender === gender
            },

            selectLook(look) {
                this.registerData.look = look
            },

            async onFormRegisterSubmit() {
                if(this.loading) return

                this.loading = true

                if(this.registerReferrerData.code) {
                    this.registerData.referrer_code = this.registerReferrerData.code
                }

                const recaptchaResponse = document.querySelector('#register-form #g-recaptcha-response'),
                    turnstile = document.querySelector('#register-form [name="cf-turnstile-response"]')

                if(recaptchaResponse && recaptchaResponse.value.length) {
                    this.registerData.recaptcha = recaptchaResponse.value
                }

                if(turnstile && turnstile.value.length) {
                    this.registerData['cf-turnstile-response'] = turnstile.value
                }

                await Authentication._attemptAuthentication('/register', this.registerData,
                    () => {
                        Authentication._treatResponseSuccess(this, __('You have been registered successfully!'))
                    },
                    (response) => {
                        Authentication._treatResponseErrors(this, response)
                    },
                    () => {
                        this.$dispatch('orion:alert', {
                            message: __('Please fill in all register fields'),
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
                    response => {
                        Authentication._treatResponseSuccess(this, __('You have been logged in successfully.'), !response.data.two_factor)

                        if(!response.data.two_factor) return

                        setTimeout(() => {
                            window.location.href = '/two-factor-challenge'
                        }, 1500)
                    },
                    (response) => {
                        Authentication._treatResponseErrors(this, response)
                    },
                    () => {
                        this.$dispatch('orion:alert', {
                            message: __('Please fill in all login fields'),
                            type: 'error'
                        })
                    }
                )

                setTimeout(() => this.loading = false, 2000)
            }
        }
    }

    static async _attemptAuthentication(url, formData, onSuccessCallback, onFailureCallback, onInvalidFieldsCallback = null) {
        await Authentication._validateFields(formData)
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
