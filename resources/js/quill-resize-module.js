if (typeof window !== 'undefined') {
    import('quill-resize-module/dist/resize.js').then(module => {
        const QuillResize = module.default || module;
        if (window.Quill) {
            window.Quill.register('modules/resize', QuillResize);
        }
        window.QuillResize = QuillResize;
    }).catch(console.error);
}
