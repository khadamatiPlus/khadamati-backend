import 'alpinejs'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import 'select2/dist/css/select2.min.css';

window.$ = window.jQuery = require('jquery');
window.Swal = require('sweetalert2');

// CoreUI
require('@coreui/coreui');

// Boilerplate
require('../plugins');
require('bootstrap-tagsinput/dist/bootstrap-tagsinput');
require('select2/dist/js/select2');


//text area CKEditor work
let textArea = document.querySelectorAll( "textarea" );
ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            'heading',
            '|',
            'bold',
            'italic',
            'link',
            '|',
            'bulletedList',
            'numberedList',
            'blockQuote',
            '|',
            'insertTable',
            '|',
            'undo',
            'redo'
        ],

    },
    table: {
        contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
    }
};
function MinHeightPlugin(editor) {
    this.editor = editor;
}

MinHeightPlugin.prototype.init = function() {
    this.editor.ui.view.editable.extendTemplate({
        attributes: {
            style: {
                minHeight: '15rem'
            }
        }
    });
};
let lang = document.documentElement.lang;
ClassicEditor.builtinPlugins.push(MinHeightPlugin);
for (var i = 0; i < textArea.length; ++i) {
    ClassicEditor
        .create(textArea[i],{
            language: {
                ui:lang,
                content:lang
            }
        })
        .then( editor => {
        } )
        .catch( error => {
            console.error( error.stack );
        } );
}
//end CKEditor work


//select2 work
var dropdowns = document.querySelectorAll('select');

for (var x = 0; x < dropdowns.length; x++){
    if(!dropdowns[x].hasAttribute('wire:model') && !dropdowns[x].classList.contains('without-select2') && !dropdowns[x].hasAttribute('x-on:change')){
        $(dropdowns[x]).select2();
    }
}
//end select2 work

//Boostrap Validator work
let forms = document.querySelectorAll('form')

// Loop over them and prevent submission
Array.prototype.slice.call(forms)
    .forEach(function (form) {
        form.classList.add('needs-validation')
        form.setAttribute('novalidate','')
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, true)

        //add asterisk red for required inputs
        let inputs = $(form).find(':input,textarea');
        $(inputs).each(function (i, item){
            if(item.classList.contains('required-textarea') || item.classList.contains('required') || item.hasAttribute('required')){
                $(item).parent().parent().find('label').addClass('required-label');
            }
        });
    });
//end Boostrap Validator work
