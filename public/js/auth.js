let spinner = document.querySelector('.spinner');

window.onload = function () {
    setupForms();
};

function showSpinner() {
    spinner.classList.add('spinner--visible');
}

function setupForms() {
    document.querySelectorAll('[data-on-submit="show-spinner"]').forEach((form) => {
        form.addEventListener('submit', () => {
            showSpinner();
        });
    });
}
