import 'lightgallery/css/lightgallery-bundle.min.css'
import lgThumbnail from 'lightgallery/plugins/thumbnail'
import { default as lightGalleryLibrary } from 'lightgallery'

export default class ImageVisualizationWrapper {
    static start() {
        document.addEventListener('alpine:init', ImageVisualizationWrapper._startComponent())
    }

    static _startComponent() {
        ImageVisualizationWrapper._registerPhotosPageComponent()
    }

    static _registerPhotosPageComponent() {
        lightGalleryLibrary(document.getElementById('lightgallery'), {
            plugins: [lgThumbnail],
            exThumbImage: 'data-src',
            selector: '.lightgallery-image',
            licenseKey: '0000-0000-0000-0000',
        })
    }
}
