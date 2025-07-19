import QuillResize from 'quill-resize-module';

if (window.Quill) {
    window.Quill.register('modules/resize', QuillResize);
}

window.QuillResize = QuillResize;