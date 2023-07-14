import { default as defaultXSS } from "xss"

export default class XssWrapper {
    static clean(html) {
        return defaultXSS(html, {
            whiteList: {
                span: ['class'],
                br: [],
                b: [],
                i: [],
                u: [],
                s: []
            }
        })
    }

    static cleanWidget(html) {
        return defaultXSS(html, {
            whiteList: {
                div: ['class', 'style'],
                span: ['class'],
                a: ['class'],
                img: ['src', 'alt', 'width'],
                input: ['class'],
                br: [],
                button: ['class']
            }
        })
    }
}
