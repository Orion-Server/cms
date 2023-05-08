const frame = document.querySelector("iframe#nitro-client");

window.FlashExternalInterface = {
    disconnect: () => {
        console.log('You has been disconnected')
    },
};

if (frame && frame.contentWindow) {
    window.addEventListener("message", (ev) => {
        if (!frame || ev.source !== frame.contentWindow) return

        const legacyInterface = "Nitro_LegacyExternalInterface"

        if (typeof ev.data !== "string") return

        if (!ev.data.startsWith(legacyInterface)) return

        const { method, params } = JSON.parse(ev.data.substring(legacyInterface.length))

        if (!("FlashExternalInterface" in window)) return

        const fn = window.FlashExternalInterface[method]

        if (fn) fn(...params)
    })
}


