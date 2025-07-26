Quill.register("modules/htmlEditButton", htmlEditButton);
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            [{
                'header': 1
            }, {
                'header': 2
            }], // custom button values
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction

            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],

            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],

            ['clean'] // remove formatting button
        ];

        var htmlEditButtonOption = {
            debug: true, // logging, default:false
            msg: "Source Code", //Custom message to display in the editor, default: Edit HTML here, when you click "OK" the quill editor's contents will be replaced
            okText: "Save", // Text to display in the OK button, default: Ok,
            cancelText: "Cancel", // Text to display in the cancel button, default: Cancel
            buttonHTML: "&lt;&gt;", // Text to display in the toolbar button, default: <>
            buttonTitle: "Show HTML source", // Text to display as the tooltip for the toolbar button, default: Show HTML source
            syntax: false, // Show the HTML with syntax highlighting. Requires highlightjs on window.hljs (similar to Quill itself), default: false
            prependSelector: 'div#myelement', // a string used to select where you want to insert the overlayContainer, default: null (appends to body),
            editorModules: {} // The default mod
        }
        var editorId = [".quill-editor"];
        for(editor of editorId){
            createEditor(editor);
        }

        function createEditor(selector) {
            var quill = new Quill(selector, {
                modules: {
                    htmlEditButton: htmlEditButtonOption,
                    // {
                    //     debug: true, // logging, default:false
                    //     msg: "Source Code", //Custom message to display in the editor, default: Edit HTML here, when you click "OK" the quill editor's contents will be replaced
                    //     okText: "Save", // Text to display in the OK button, default: Ok,
                    //     cancelText: "Cancel", // Text to display in the cancel button, default: Cancel
                    //     buttonHTML: "&lt;&gt;", // Text to display in the toolbar button, default: <>
                    //     buttonTitle: "Show HTML source", // Text to display as the tooltip for the toolbar button, default: Show HTML source
                    //     syntax: false, // Show the HTML with syntax highlighting. Requires highlightjs on window.hljs (similar to Quill itself), default: false
                    //     prependSelector: 'div#myelement', // a string used to select where you want to insert the overlayContainer, default: null (appends to body),
                    //     editorModules: {} // The default mod
                    // },
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });

            var form = document.querySelector('form');
            $(document).on('submit', 'form', function(){
                var about = document.querySelector('textarea[name=description]');
                var aboutppage = document.querySelector('textarea[name=banner_description]');
                var faqpage = document.querySelector('textarea[name=answer]');
                var paymentterm = document.querySelector('textarea[name=content]');
                var header = document.querySelector('textarea[name=content]');
                var footer = document.querySelector('textarea[name=content]');

                if(about){     
                    about.value= quill.root.innerHTML;
                }
                else if(aboutppage){  
                    aboutppage.value= quill.root.innerHTML;
                }  
                else if(faqpage){  
                    faqpage.value= quill.root.innerHTML;
                }    
                else if(paymentterm){  
                    paymentterm.value= quill.root.innerHTML;
                }          
                else if(header){  
                    header.value= quill.root.innerHTML;
                }
                else if(footer){  
                    footer.value= quill.root.innerHTML;
                }      
            });
        }

        