import 'lightgallery/css/lightgallery-bundle.min.css'
import lgThumbnail from 'lightgallery/plugins/thumbnail'
import { default as lightGalleryLibrary } from 'lightgallery'

class ImageVisualizationWrapper {
    start() {
        document.addEventListener('turbolinks:load', () => this._startComponent())
    }

    _startComponent() {
        this._registerPhotosPageComponent()
    }

    _registerPhotosPageComponent() {
        lightGalleryLibrary(document.getElementById('lightgallery'), {
            plugins: [lgThumbnail],
            exThumbImage: 'data-src',
            selector: '.lightgallery-image',
            licenseKey: '0000-0000-0000-0000',
        })
    }
}

export default new ImageVisualizationWrapper()
