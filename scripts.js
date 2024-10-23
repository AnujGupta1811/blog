// Initialize TinyMCE on the content textarea
tinymce.init({
    selector: 'textarea#content',
    plugins: 'advlist autolink lists link image charmap print preview hr code table',
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code | table',
    menubar: false,
    height: 300,
    content_style: "body { font-family: Arial, sans-serif; font-size: 14px; }", // Customize font inside the editor
    images_upload_url: '/upload', // URL to upload images (change as needed)
    automatic_uploads: true,
    file_picker_types: 'image',
    file_picker_callback: function (callback, value, meta) {
        if (meta.filetype === 'image') {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function () {
                    callback(reader.result, { alt: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    }
});
