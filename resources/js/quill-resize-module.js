import ImageResize from 'quill-resize-module/dist/resize.js';

if (window.Quill) {
    window.Quill.register('modules/resize', ImageResize);
}

window.ImageResize = ImageResize;