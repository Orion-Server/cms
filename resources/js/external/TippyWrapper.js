import tippy, { createSingleton } from 'tippy.js'

export default class TippyWrapper {
    static start() {
        if(!(this.instance instanceof TippyWrapper)) {
            this.instance = new TippyWrapper()
        }

        document.addEventListener('turbolinks:load', () => {
            this.instance.bindTooltipTriggers()
        })
    }

    getInstance() {
        return this.instance
    }

    bindTooltipTriggers() {
        this.detectSingletonTooltips()
        this.detectSimpleTooltips()
    }

    detectSimpleTooltips() {
        const simpleTooltips = document.querySelectorAll('[data-tippy]')

        Array.from(simpleTooltips).forEach(tooltip => this.createTippyInstance(tooltip))
    }

    detectSingletonTooltips() {
        const singletonTooltips = document.querySelectorAll('[data-tippy-singleton]')

        createSingleton(
            Array.from(singletonTooltips)
                .map(tooltip => this.createTippyInstance(tooltip)),
            {
                moveTransition: 'transform 0.2s ease-out',
                theme: 'translucent',
                allowHTML: true
            }
        )
    }

    createTippyInstance(element, options = {}) {
        const content = element.dataset.tippyContent,
            placement = element.dataset.tippyPlacement,
            interactive = element.dataset.tippyInteractive,
            trigger = element.dataset.tippyTrigger

        options = Object.assign(options, {
            content,
            interactive: interactive !== undefined,
            placement,
            trigger,
            allowHTML: true,
            theme: 'translucent'
        })

        return tippy(element, options)
    }
}
