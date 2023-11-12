let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let spinner = document.querySelector('.spinner');

window.onload = function () {
    setupComponents();
    setupAsideToggler();
    setupTableCheckboxes();
    setupModals();
    stupFormSpinner();
    highlightActiveNavbarLink();
    setupNestedSet();
    setupLocalImageInputs();
};

window.onresize = function () {
    validateAccordionCollapses();
}

function setupComponents() {
    // Singular Selectize
    $('.selectize-singular').selectize({});

    // Singular Selectize Linked
    $('.selectize-singular--linked').selectize({
        onChange(value) {
            window.location = value;
        }
    });

    // Miltiple Selectize
    $('.selectize-multiple').selectize({});

    // DateTimePicker with NOW value
    $('.date-time-picker[value=""]').datetimepicker({
        // mask: '9999/19/39 29:59',
        format: 'Y-m-d H:i:s',
        formatTime: 'H:i:s',
        formatDate: 'Y-m-d',
        value: getCurrentDateAndTime(),
        lang: 'ru',
    });

    // DateTimePicker without value
    $('.date-time-picker[value!=""]').datetimepicker({
        // mask: '9999/19/39 29:59',
        format: 'Y-m-d H:i:s',
        formatTime: 'H:i:s',
        formatDate: 'Y-m-d',
        lang: 'ru',
    });

    // Nested Sortable
    $('.nested').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        excludeRoot: true,
        maxLevels: 2,
        isTree: true,
        expandOnHover: 700,
        startCollapsed: true,
        branchClass: 'nested__item--parent',
        leafClass: 'nested__item--leaf',
        collapsedClass: 'nested__item--collapsed',
        expandedClass: 'nested__item--expanded',
        hoveringClass: 'nested__item--hover',
    });

    setupSimditor();
    setupAccordion();
}

function setupSimditor() {
    Simditor.locale = 'ru-RU';

    // Simple WYSIWYGS
    document.querySelectorAll('.wysiwyg-textarea').forEach((textarea) => {
        new Simditor({
            textarea: textarea,
            toolbarFloatOffset: '60px',
            imageButton: 'upload',
            toolbar: ['title', 'bold', 'italic', 'underline', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'hr', '|', 'indent', 'outdent', 'alignment'] //image removed
            // cleanPaste: true, //clear all styles after pasting,
        });
    });

    // Imaged WYSIWYGS
    document.querySelectorAll('.simditor-wysiwyg--imaged').forEach((textarea) => {
        new Simditor({
            textarea: textarea,
            toolbarFloatOffset: '60px',
            imageButton: 'upload',
            toolbar: ['title', 'bold', 'italic', 'underline', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'hr', '|', 'indent', 'outdent', 'alignment', 'image'],
            upload: {
                url: '/simditor-image/upload',   // image upload url by server
                params: { // additional parameters for request
                    folder: 'posts'
                },
                fileKey: 'image', // input name
                connectionCount: 10,
                leaveConfirm: 'Пожалуйста дождитесь окончания загрузки изображений на сервер! Вы уверены что хотите закрыть страницу?'
            },
            defaultImage: '/img/dashboard/default-image.png', // default image thumb while uploading
        });
    });
}

function setupAccordion() {
    document.querySelectorAll('.accordion__button').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let button = evt.target;
            let accordion = button.closest('.accordion');
            let targetItem = button.closest('.accordion__item');
            let targetCollapse = targetItem.querySelector('.accordion__collapse');

            // close any other active items
            accordion.querySelectorAll('.accordion__item--active').forEach((activeItem) => {
                if (activeItem !== targetItem) {
                    activeItem.querySelector('.accordion__collapse').style.height = null;
                    activeItem.classList.remove('accordion__item--active');
                }
            });

            // toggle collapse hieght & item active class
            targetCollapse.style.height = targetCollapse.clientHeight ? null : targetCollapse.scrollHeight + 'px';
            targetItem.classList.toggle('accordion__item--active');
        });
    });

    validateAccordionCollapses();
}

function validateAccordionCollapses() {
    document.querySelectorAll('.accordion__item--active').forEach((item) => {
        let collapse = item.querySelector('.accordion__collapse');
        collapse.style.height = collapse.scrollHeight + 'px';
    });
}

// Used in JQuery Date Time plugin
function getCurrentDateAndTime() {
    let currentdate = new Date();

    return currentdate.getFullYear() + '-'
        + String(currentdate.getMonth() + 1).padStart(2, '0') + '-'
        + String(currentdate.getDate()).padStart(2, '0') + ' '
        + String(currentdate.getHours()).padStart(2, '0') + ':'
        + String(currentdate.getMinutes()).padStart(2, '0') + ':'
        + String(currentdate.getSeconds()).padStart(2, '0');
}

function debounce(callback, timeoutDelay = 500) {
    let timeoutId;

    return (...rest) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => callback.apply(this, rest), timeoutDelay);
    };
}

// Auto highlight navbars current route link
function highlightActiveNavbarLink() {
    let navbar = document.querySelector('.navbar');
    let currentUlr = window.location.origin + window.location.pathname;

    // Links
    navbar.querySelectorAll('.menu__link').forEach((link) => {
        if (link.href == currentUlr) {
            link.classList.add('menu__item--active');
        }
    });

    // Accordion links
    navbar.querySelectorAll('.accordion__collapse-link').forEach((link) => {
        if (link.href == currentUlr) {
            link.classList.add('accordion__collapse-link--active');
        }
    });
}

function setupAsideToggler() {
    document.querySelector('.aside-toggler').addEventListener('click', () => {
        document.body.classList.toggle('body--asideless');
    });
}

function setupTableCheckboxes() {
    let selectAllBtn = document.querySelector('.header__action-select-all');

    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', () => {
            let table = document.querySelector('.table')
            let checkboxes = table.querySelectorAll('input[type="checkbox"]');

            // check if all checkboxes selected
            let checkedAll = true;

            for (let chb of checkboxes) {
                if (!chb.checked) {
                    checkedAll = false;
                    break;
                }
            }

            // toggle checkbox statements
            for (let chb of checkboxes) {
                chb.checked = !checkedAll;
            }
        });
    }
}

// ************ MODAL ************
function showModal(modal) {
    modal.classList.add('modal--visible');
}

function hideModal(modal) {
    modal.classList.remove('modal--visible');
}

function hideAllActiveModals() {
    document.querySelectorAll('.modal--visible').forEach((modal) => {
        hideModal(modal);
    });
}

function setupModals() {
    // Show modal
    document.querySelectorAll('[data-action="show-modal"]').forEach((item) => {
        item.addEventListener('click', (evt) => {
            hideAllActiveModals();
            let modal = document.querySelector(evt.target.dataset.modalTarget);
            showModal(modal);
        });
    });

    // Hide modal
    document.querySelectorAll('[data-action="hide-modal"], .modal__overlay').forEach((item) => {
        item.addEventListener('click', () => {
            hideAllActiveModals();
        });
    });

    setupFormModals();
}

function setupFormModals() {
    // Single Item Destroy Modal
    document.querySelectorAll('.table__button--destroy').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let modal = document.querySelector('.modal--single-destroy');
            let input = modal.querySelector('[name="id[]"]');

            // Change input value and show modal
            input.value = evt.target.dataset.itemId;
            showModal(modal);
        });
    });

    // Single Item Restore Modal
    document.querySelectorAll('.table__button--restore').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let modal = document.querySelector('.modal--single-restore');
            let input = modal.querySelector('[name="id"]');

            // Change input value and show modal
            input.value = evt.target.dataset.itemId;
            showModal(modal);
        });
    });
}
// ************ /END MODAL ************

function stupFormSpinner() {
    document.querySelectorAll('[data-on-submit="show-spinner"]').forEach((item) => {
        item.addEventListener('submit', () => {
            spinner.classList.add('spinner--visible');
        });
    });
}

function setupNestedSet() {
    document.querySelectorAll('.nested__item-toggler').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let item = evt.target.closest('.nested__item');
            item.classList.toggle('nested__item--collapsed');
            item.classList.toggle('nested__item--expanded');
        });
    });

    document.querySelectorAll('.nested__item-destroy-btn').forEach((item) => {
        item.addEventListener('click', (evt) => {
            evt.target.closest('.nested__item').remove();
        });
    });

    let updateNestedBtn = document.querySelector('[data-action="update-nestedset"]');

    if (updateNestedBtn) {
        updateNestedBtn.addEventListener('click', () => {
            let url = updateNestedBtn.dataset.url;
            let model = updateNestedBtn.dataset.model;

            let params = {
                itemsHierarchy: $('.nested').nestedSortable('toHierarchy', { startDepthCount: 0 }),
                itemsArray: $('.nested').nestedSortable('toArray', { startDepthCount: 0 })
            }

            if (model) {
                params.model = model;
            }

            const xhttp = new XMLHttpRequest();

            xhttp.onloadend = function () {
                if (xhttp.status == 200) {
                    window.location.reload();
                } else {
                    xhttp.abort();
                }
            }

            xhttp.open('POST', url, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
        });
    }
}

function setupLocalImageInputs() {
    document.querySelectorAll('[data-action="display-local-image"]').forEach((input) => {
        input.addEventListener('change', (evt) => {
            let imgTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            let imgTypesRegex = new RegExp('(' + imgTypes.join('|').replace(/\./g, '\\.') + ')$');

            let file = evt.target.files[0];
            let image = evt.target.nextElementSibling;

            if (imgTypesRegex.test(file.type)) {
                image.src = URL.createObjectURL(file);
            } else {
                input.value = '';
                alert('Формат файла не поддерживается!');
            }
        });
    });
}
