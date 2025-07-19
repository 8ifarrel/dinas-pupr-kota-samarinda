if (typeof window !== 'undefined') {
    import('quill-resize-module').then(module => {
        const QuillResize = module.default || window.QuillResize;
        if (window.Quill && QuillResize) {
            window.Quill.register('modules/resize', QuillResize);
        }
    }).catch(console.error);
}
