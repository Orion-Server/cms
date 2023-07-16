import DOMPurify from 'dompurify';

export default class XssWrapper {
    static clean(html) {
        return DOMPurify.sanitize(html, { USE_PROFILES: { html: true } })
    }
}
