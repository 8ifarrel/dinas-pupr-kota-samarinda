import ImageResize from 'quill-resize-module';

if (window.Quill) {
    window.Quill.register('modules/resize', ImageResize);
}

window.ImageResize = ImageResize;