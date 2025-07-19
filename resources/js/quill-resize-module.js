import QuillResize from 'quill-resize-module/dist/resize.js';

if (window.Quill) {
    window.Quill.register('modules/resize', QuillResize);
}

window.QuillResize = QuillResize;