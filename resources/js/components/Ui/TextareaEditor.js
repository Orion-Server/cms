import Alpine from "alpinejs"

class TextareaEditor {
    start() {
        document.addEventListener("alpine:init", () => this._startComponent())
    }

    _startComponent() {
        Alpine.data("textareaEditor", () => ({
            loading: false,

            init() {
                this.initButtons()
            },

            async onSubmit() {
                if(this.loading) return

                this.loading = true

                const content = this.$refs.textarea.value

                await axios.post(this.$refs.form.action, { content }).then(response => {
                        if(!response.data.success) return

                        this.$refs.textarea.value = ''

                        this.$dispatch('orion:alert', {
                            type: 'success',
                            message: response.data.message
                        })
                    })
                    .catch(error => {
                        const message = error.response?.data?.message

                        if(message) {
                            this.$dispatch('orion:alert', {
                                type: 'error',
                                message
                            })
                        }

                        console.error('[TextareaEditorForm] - ', error)
                    })

                setTimeout(() => this.loading = false, 2000)
            },

            initButtons() {
                const buttons = document.querySelectorAll("[data-editor]")

                Array.from(buttons).map((button) =>
                    this.treatButtonAction(button)
                );
            },

            treatButtonAction(button) {
                const textarea = this.$refs.textarea

                if (!textarea) return;

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
                                : textarea.value.length;
                    })
                })
            },
        }))
    }
}

export default new TextareaEditor();
