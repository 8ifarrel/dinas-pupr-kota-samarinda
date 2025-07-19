import ImageResize from 'quill-resize-module/dist/resize.js';

if (window.Quill) {
    window.Quill.register('modules/imageResize', ImageResize);
}

window.ImageResize = ImageResize;