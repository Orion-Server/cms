import Alpine from "alpinejs";

class TextareaEditor {
    start() {
        document.addEventListener("alpine:init", () => this._startComponent());
    }

    _startComponent() {
        Alpine.data("textareaEditor", () => ({
            init() {
                this.initButtons();
            },

            initButtons() {
                const buttons = document.querySelectorAll("[data-editor]");

                Array.from(buttons).map((button) =>
                    this.treatButtonAction(button)
                );
            },

            treatButtonAction(button) {
                const textarea = this.$refs.textarea;

                if (!textarea) return;

                button.addEventListener("click", () => {
                    const before = button.dataset.before,
                        after = button.dataset.after;

                    const { selectionStart, selectionEnd } = textarea;

                    const textareaLength = textarea.value.length,
                        selectedText = textarea.value.substring(
                            selectionStart,
                            selectionEnd
                        ),
                        selectedTextUpdated = before + selectedText + after;

                    textarea.value =
                        textarea.value.substring(0, selectionStart) +
                        selectedTextUpdated +
                        textarea.value.substring(selectionEnd, textareaLength);

                    this.$nextTick(() => {
                        textarea.focus();

                        textarea.selectionStart =
                            selectionStart == selectionEnd
                                ? selectionStart + before.length
                                : textarea.value.length;
                    });
                });
            },
        }));
    }
}

export default new TextareaEditor();
