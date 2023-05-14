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
}
