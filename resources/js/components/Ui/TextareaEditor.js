import Alpine from "alpinejs"
import Turbolinks from "turbolinks"
import XssWrapper from "../../external/XssWrapper"

class TextareaEditor {
    start() {
        document.addEventListener("alpine:init", this._startComponent)
    }

    _startComponent() {
        Alpine.data("textareaEditor", (automaticPreview = false) => ({
            loading: false,

            showPreview: false,
            previewLoading: false,
            previewText: null,

            init() {
                this.initEditorButtons()

                document.addEventListener('orion:note-value', ({ detail: eventData }) => {
                    if(!eventData?.data || !eventData?.parsedData) return

                    this.$refs.textarea.value = eventData.data
                    this.previewText = XssWrapper.clean(eventData.parsedData)
                })
            },

            initEditorButtons() {
                const buttons = document.querySelectorAll("[data-editor]")

                Array.from(buttons).map((button) =>
                    this.treatEditButtonAction(button)
                )
            },

            treatEditButtonAction(button) {
                const textarea = this.$refs.textarea

                if (!textarea) return

                button.addEventListener("click", () => {
                    const before = button.dataset.before,
                        after = button.dataset.after

                    const { selectionStart, selectionEnd } = textarea

                    const textareaLength = textarea.value.length,
                        selectedText = textarea.value.substring(
                            selectionStart,
                            selectionEnd
                        ),
                        selectedTextUpdated = before + selectedText + after

                    textarea.value =
                        textarea.value.substring(0, selectionStart) +
                        selectedTextUpdated +
                        textarea.value.substring(selectionEnd, textareaLength)

                    this.$nextTick(() => {
                        textarea.focus()

                        textarea.selectionStart =
                            selectionStart == selectionEnd
                                ? selectionStart + before.length
                                : textarea.value.length

                        textarea.dispatchEvent(new Event('input'))
                    })
                })
            },

            async onSubmit() {
                if (this.loading) return

                this.loading = true

                const content = this.$refs.textarea.value

                await axios
                    .post(this.$refs.form.action, { content })
                    .then((response) => {
                        if (!response.data.success) return

                        this.$refs.textarea.value = ""

                        this.$dispatch("orion:alert", {
                            type: "success",
                            message: response.data.message,
                        })

                        Turbolinks.visit(response.data.href)
                    })
                    .catch((error) => {
                        const message = error.response?.data?.message

                        if (message) {
                            this.$dispatch("orion:alert", {
                                type: "error",
                                message,
                            })
                        }

                        console.error("[TextareaEditorForm] - ", error)
                    })

                setTimeout(() => (this.loading = false), 2000)
            },

            onPreviewRequest() {
                if(this.showPreview) {
                    this.showPreview = false
                    return
                }

                this.requestPreview(true, () => this.showPreview = true)
            },

            async requestPreview(requestedManually = false, callback = null) {
                if(!automaticPreview && !requestedManually) return

                const textarea = this.$refs.textarea

                if((!textarea || !textarea.value.length || this.previewLoading) && !automaticPreview) return

                if(!textarea.value.length) {
                    this.previewText = ''
                    return
                }

                this.previewLoading = true

                await axios.post('/api/bbcode/preview', { content: textarea.value })
                    .then(response => {
                        if(!response.data.success) {
                            const { message } = response.data

                            this.$dispatch('orion:alert', { type: 'error', message })
                            return
                        }

                        this.previewText = XssWrapper.clean(response.data.content)

                        if(callback) callback()
                    })
                    .catch(error => console.error('[TextareaEditorPreview] - ', error))

                setTimeout(() => this.previewLoading = false, 2000)
            }
        }))
    }
}

export default new TextareaEditor()
