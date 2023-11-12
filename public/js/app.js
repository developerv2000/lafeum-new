let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let spinner = document.querySelector('.spinner');
let currentPathName = window.location.origin + window.location.pathname;

let vocabularyListContainer = document.querySelector('.vocabulary-list-container');
let vocabularySearchForm = document.querySelector('.vocabulary-index__search');
var vocabularyListPopup, vocabularyListPopupInner;
var vocabularyBody = []; // used to store each vocabulary terms body responded from the server
var subterms; // used to store JSONed subterms (updates on terms list ajax filter)

let videoModal = document.querySelector('#videoModal');
let videoModalBox = videoModal.querySelector('.modal__box');
let rightbarVideoModal = document.querySelector('#rightbarVideoModal');

window.onload = function () {
    setupComponents();
    setupExpandMoreButtons();
    setupForms();
    setupLocalSearch();
    setupTermPopups();
    setupVocabularyPopups();
    setupVocabularyFilter();
    setupLeftbarCategoriesFilter();
    setupModals();
    setupRightbarVideoModal();
    setupVideoCardModals();
    fixLongLeftbarHeight();
    setupAuthenticationForms();
    setupFormClearButtons();
    setupLikeButtons();
    setupFavoriteButtons();
    hightlightLeftbarLinks();
    decodePaginationUrlBrackets();
    decodeHistoryUrlBrackets();
};

document.addEventListener('click', function (evt) {
    document.querySelectorAll('.dropdown--active').forEach((activeDropdown) => {
        // Check if event target is outside of active dropdown
        if (!activeDropdown.contains(evt.target)) {
            activeDropdown.classList.remove('dropdown--active');
        }
    });
});


function debounce(callback, timeoutDelay = 500) {
    let timeoutId;

    return (...rest) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => callback.apply(this, rest), timeoutDelay);
    };
}

function showSpinner() {
    spinner.classList.add('spinner--visible');
}

function hideSpinner() {
    spinner.classList.remove('spinner--visible');
}


// ********** EXPAND MORE **********
function setupExpandMoreButtons() {
    // Remove excess buttons
    document.querySelectorAll('.expand-more').forEach(function (button) {
        let cardText = button.previousElementSibling;

        if (cardText.clientHeight == cardText.scrollHeight) {
            cardText.classList.add('main-card__text--expanded');
            button.remove();
        }
    });

    // Add click listeners
    document.querySelectorAll('.expand-more').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let btn = evt.target;
            let cardText = btn.previousElementSibling;

            btn.classList.toggle('expand-more--active');
            cardText.classList.toggle('main-card__text--expanded');
        });
    });
}
// ********** /END EXPAND MORE **********

function setupForms() {
    document.querySelectorAll('[data-submit="disabled"]').forEach((form) => {
        form.addEventListener('submit', (evt) => {
            evt.preventDefault();
        });
    });

    document.querySelectorAll('[data-on-submit="show-spinner"]').forEach((form) => {
        form.addEventListener('submit', () => {
            showSpinner();
        });
    });


    // Profile Ava Form
    let avaInput = document.querySelector('.profile-form__ava-input');

    if (avaInput) {
        avaInput.addEventListener('change', (evt) => {
            showSpinner();
            let imgTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            let imgTypesRegex = new RegExp('(' + imgTypes.join('|').replace(/\./g, '\\.') + ')$');
            let file = evt.target.files[0];

            if (imgTypesRegex.test(file.type)) {
                document.querySelector('.profile-form__ava-image').src = URL.createObjectURL(file);
            }

            hideSpinner();
        });
    }

    // Folder Edit Forms
    document.querySelectorAll('.folders-edit__edit-btn').forEach((btn) => {
        btn.addEventListener('click', (evt) => {
            let folderItem = evt.target.closest('.folders-list__item');
            folderItem.classList.add('folders-list__item--editable');

            folderItem.querySelector('.folders-list__input').focus();
        })
    });
}

function setupComponents() {
    // Collapse
    document.querySelectorAll('.collapse__button').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let collapse = evt.target.closest('.collapse');
            collapse.classList.toggle('collapse--active');
        });
    });

    // Accordion
    document.querySelectorAll('.accordion__button').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let button = evt.target;
            let accordion = button.closest('.accordion');
            let targetItem = button.closest('.accordion__item');

            // close any other active items
            accordion.querySelectorAll('.accordion__item--active').forEach((activeItem) => {
                if (activeItem !== targetItem) {
                    activeItem.classList.remove('accordion__item--active');
                }
            });

            // toggle item active class
            targetItem.classList.toggle('accordion__item--active');
        });
    });

    // Dropdown
    document.querySelectorAll('.dropdown__button').forEach((button) => {
        button.addEventListener('click', (evt) => {
            evt.target.closest('.dropdown').classList.toggle('dropdown--active');
        });
    });

    // Scroll Top Button
    document.querySelector('.scroll-top').addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
}

function setupLocalSearch() {
    document.querySelectorAll('[data-action="local-search"]').forEach((input) => {
        input.addEventListener('input', debounce(function (evt) {
            let keyword = evt.target.value.toLowerCase();
            let selector = evt.target.dataset.selector;

            // Hide & show elements
            document.querySelectorAll(selector).forEach((item) => {
                item.style.display = item.textContent.toLowerCase().includes(keyword) ? null : 'none'
            });
        }));
    });
}

function fixLongLeftbarHeight() {
    let leftbar = document.querySelector('.leftbar--fixed-height');
    if (!leftbar) return;

    let mainHeight = document.querySelector('.main').clientHeight;
    if (mainHeight > window.innerHeight && mainHeight > 2000) {
        document.documentElement.style.setProperty('--leftbar-max-height', (mainHeight - 200) + 'px');
    }
}

function hightlightLeftbarLinks() {
    document.querySelectorAll('.leftbar__collapse-link').forEach((link) => {
        if (link.href == currentPathName) {
            link.classList.add('leftbar__collapse-link--active');
        }
    });

    // Profile leftbar
    document.querySelectorAll('.profile-leftbar__link').forEach((link) => {
        if (link.href == currentPathName) {
            link.classList.add('profile-leftbar__link--active');
        }
    });
}

// ************ TERMS ************
function setupTermPopups() {
    document.querySelectorAll('.terms-card__text').forEach((text) => {
        text.querySelectorAll('a').forEach((link) => {
            if (link.href == '') return;

            let url = new URL(link.href);

            // Get ID from pathname https://lafeum.ru/term/{id}
            if (url.hostname == 'lafeum.ru') {
                let id = url.pathname.slice(6);
                link.dataset.targetId = id;

                link.addEventListener('mouseover', function () {
                    showSubtermPopup(link);
                });

                link.addEventListener('mouseleave', function () {
                    hideSubtermPopup();
                });
            }
        });
    });
}

function showSubtermPopup(link) {
    let targetID = link.dataset.targetId;
    let card = link.closest('.terms-card');
    let popup = card.querySelector('.terms-card__popup');
    let popupInner = popup.querySelector('.terms-card__popup-inner');

    // escape exceed multiple change
    if (popupInner.dataset.subtermId != targetID) {
        // subterms defined in blade (terms-list)
        popupInner.innerHTML = subterms.find(obj => obj.id == targetID).body;
        popupInner.dataset.subtermId = targetID;
        popup.style.top = (link.offsetTop + 30) + 'px';
    }

    popup.classList.add('terms-card__popup--visible');
}

function hideSubtermPopup() {
    document.querySelectorAll('.terms-card__popup--visible').forEach((popup) => {
        popup.classList.remove('terms-card__popup--visible');
    });
}

function updateSubtermsValue() {
    let list = document.querySelector('.terms-list');
    let script = list.querySelector('script').innerHTML;
    eval(script);
}
// ************ /END TERMS ************


// ************ VOCABULARY ************
function setupVocabularyPopups() {
    let vocabularyList = document.querySelector('.vocabulary-list');
    if (!vocabularyList) return;

    vocabularyListPopup = document.querySelector('.vocabulary-list-popup');
    vocabularyListPopupInner = document.querySelector('.vocabulary-list-popup__inner');

    vocabularyList.addEventListener('mouseover', function (evt) {
        // if hover on non link element
        if (!evt.target.classList.contains('vocabulary-list__link')) {
            vocabularyListPopup.classList.remove('vocabulary-list-popup--visible');

            return;
        }

        let targ = evt.target;
        let id = targ.dataset.id;

        // Request term if it hasn`t already been loaded
        if (id in vocabularyBody == false) {
            const xhttp = new XMLHttpRequest();

            xhttp.onloadend = function () {
                if (xhttp.status == 200) {
                    vocabularyBody[id] = this.responseText;
                    updateVocabularyPopupInner(targ, id);
                }
            }

            xhttp.open('POST', '/vocabulary/get-body/' + id, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.send();

        } else {
            updateVocabularyPopupInner(targ, id);
        }
    });

    vocabularyList.addEventListener('mouseout', function () {
        vocabularyListPopup.classList.remove('vocabulary-list-popup--visible');
    });
}

function updateVocabularyPopupInner(targ, id) {
    vocabularyListPopupInner.innerHTML = vocabularyBody[id];
    vocabularyListPopup.style.top = targ.offsetTop + 28 + 'px';
    vocabularyListPopup.style.left = targ.offsetLeft + 'px';
    vocabularyListPopup.classList.add('vocabulary-list-popup--visible');
}

function setupVocabularyFilter() {
    document.querySelectorAll('.vocabulary__filter-checkbox').forEach((chb) => {
        chb.addEventListener('change', () => {
            filterVocabularyList();
        });
    });

    if (vocabularySearchForm) {
        vocabularySearchForm.addEventListener('submit', (evt) => {
            evt.preventDefault();
            filterVocabularyList();
        });

        vocabularySearchForm.querySelector('.search-form__input')
            .addEventListener('input', debounce(function () {
                filterVocabularyList();
            }));
    }
}

function filterVocabularyList() {
    showSpinner();
    let formData = new FormData(vocabularySearchForm);
    const xhttp = new XMLHttpRequest();

    xhttp.onloadend = function () {
        if (xhttp.status == 200) {
            vocabularyListContainer.innerHTML = xhttp.responseText;
            setupVocabularyPopups();
            hideSpinner();
        } else {
            xhttp.abort();
            hideSpinner();
        }
    }

    xhttp.open('POST', '/vocabulary/filter', true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(new URLSearchParams(formData));
}

// ************ /END VOCABULARY ************


// ************ Categories Filter ************
function setupLeftbarCategoriesFilter() {
    document.querySelectorAll('.checkboxed-leftbar__checkbox').forEach((chb) => {
        chb.addEventListener('change', (evt) => {
            showSpinner();

            let form = evt.target.form;
            let formData = new FormData(form);
            let [listContainer, url] = getFilterListAndUrl(form.id);

            const xhttp = new XMLHttpRequest();

            xhttp.onloadend = function () {
                if (xhttp.status == 200) {
                    listContainer.innerHTML = xhttp.responseText;
                    setupListsAfterUpdate(form.id);
                    updateLocationQueryString(formData);
                    hideSpinner();
                } else {
                    xhttp.abort();
                    hideSpinner();
                }
            }

            xhttp.open('POST', url, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send(new URLSearchParams(formData));
        });
    });
}

function getFilterListAndUrl(formID) {
    let listContainer, url;

    switch (formID) {
        case 'quotes-index-search':
            listContainer = document.querySelector('.quotes__list-container');
            url = '/quotes/filter';
            break;

        case 'videos-index-search':
            listContainer = document.querySelector('.videos__list-container');
            url = '/videos/filter';
            break;

        case 'terms-index-search':
            listContainer = document.querySelector('.terms__list-container');
            url = '/terms/filter';
            break;

        case 'photos-index-search':
            listContainer = document.querySelector('.photos__list-container');
            url = '/photos/filter';
            break;
    }

    return [listContainer, url];
}

function setupListsAfterUpdate(formID) {
    switch (formID) {
        case 'quotes-index-search':
            setupExpandMoreButtons();
            break;

        case 'videos-index-search':
            setupVideoCardModals();
            break;

        case 'terms-index-search':
            setupExpandMoreButtons();
            setupTermPopups();
            updateSubtermsValue();
            break;

        case 'photos-index-search':
            setupPhotoModals();
            validatePhotoModalComponents();
            break;
    }

    setupFavoriteButtons();
    setupFavoriteDropdowns();
    setupLikeButtons();
    setupCardShareBtns();
    decodePaginationUrlBrackets();
}

function updateLocationQueryString(formData) {
    let newUrl = currentPathName;

    // Remove empty query string
    if (formData.get('keyword') == '') {
        formData.delete("keyword");
    }

    if (formData.get('keyword' != '') || formData.get('cats[]')) {
        newUrl += '?'
    }

    const params = new URLSearchParams(formData);
    newUrl += params.toString();
    window.history.replaceState(null, '', decodeUrlBrackets(newUrl));
}
// ************ /END Categories Filter ************

function decodeUrlBrackets(url) {
    url = url.replaceAll('%5B', '[');
    url = url.replaceAll('%5D', ']');

    return url;
}

function decodePaginationUrlBrackets() {
    const pagination = document.querySelector('.pagination');

    if (pagination) {
        pagination.querySelectorAll('.pagination__link').forEach((link) => {
            if (link.href) {
                link.href = decodeUrlBrackets(link.href);
            }
        });
    }
}

function decodeHistoryUrlBrackets() {
    window.history.replaceState(null, '', decodeUrlBrackets(window.location.href));
}

// ************ Modals ************
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
            let modal = document.querySelector(evt.target.dataset.modalTarget);
            hideAllActiveModals();
            showModal(modal);
        });
    });

    // Hide modal
    document.querySelectorAll('[data-action="hide-modal"], .modal__background').forEach((item) => {
        item.addEventListener('click', () => {
            hideAllActiveModals();
        });
    });
}

function setupRightbarVideoModal() {
    let dailyPostItem = document.querySelector('.daily-posts__item--video');

    dailyPostItem.querySelector('.daily-posts__card-image').addEventListener('click', () => {
        validateRightbarVideoModal();
        showModal(rightbarVideoModal);
    });
}

function validateRightbarVideoModal() {
    let iframeContainer = rightbarVideoModal.querySelector('.videos-card__iframe-container');

    if (!iframeContainer.querySelector('iframe')) {
        let iframe = document.createElement('iframe');
        iframe.src = iframeContainer.dataset.src;
        iframeContainer.appendChild(iframe);
    }
}

function setupVideoCardModals() {
    // Video modals
    document.querySelectorAll('.videos-card__image').forEach((item) => {
        item.addEventListener('click', (evt) => {
            updateVideoModal(evt.target.closest('.videos-card'));
            validateVideoModalComponents();
            showModal(videoModal);
        });
    });
}

function updateVideoModal(card) {
    videoModalBox.innerHTML = card.outerHTML;
    let iframeContainer = videoModal.querySelector('.videos-card__iframe-container');
    let iframe = document.createElement('iframe');
    iframe.src = iframeContainer.dataset.src;
    iframeContainer.appendChild(iframe);
}

function validateVideoModalComponents() {
    validateVideoModalShareBtns();
}

function validateVideoModalShareBtns() {
    let shareDiv = videoModal.querySelector('.ya-share2');
    shareDiv.innerHTML = null;
    Ya.share2(shareDiv, {});
}

function setupPhotoModals() {
    let list = document.querySelector('.photos-list');

    // Show modal
    list.querySelectorAll('[data-action="show-modal"]').forEach((item) => {
        item.addEventListener('click', (evt) => {
            let modal = document.querySelector(evt.target.dataset.modalTarget);
            hideAllActiveModals();
            showModal(modal);
        });
    });

    // Hide modal
    list.querySelectorAll('[data-action="hide-modal"], .modal__background').forEach((item) => {
        item.addEventListener('click', () => {
            hideAllActiveModals();
        });
    });
}

function validatePhotoModalComponents() {
    validatePhotoModalShareBtns();
}

function validatePhotoModalShareBtns() {
    let list = document.querySelector('.photos-list');

    list.querySelectorAll('.ya-share2').forEach((shareDiv) => {
        Ya.share2(shareDiv, {});
    });
}
// ************ /END Modals ************


// ************ Form ************
function setupFormClearButtons() {
    document.querySelectorAll('.form-group__icon--error').forEach((button) => {
        button.addEventListener('click', (evt) => {
            let targ = evt.target;
            let formGroup = targ.closest('.form-group');
            let label = formGroup.querySelector('.input');
            label.value = null;
            label.focus();
        });
    });
}

function displayFormErrors(form, response) {
    let errors = response.errors;

    for (let name in errors) {
        let input = form.querySelector(`input[name=${name}]`);
        let formGroup = input.closest('.form-group');
        formGroup.classList.add('form-group--error');

        let label = formGroup.querySelector('.label');
        label.innerHTML = errors[name];
    }
}

function resetFormErrors(form) {
    form.querySelectorAll('.form-group').forEach((group) => {
        group.classList.remove('form-group--error');
        group.querySelector('.label').innerHTML = null;
    });
}
// ************ /END Form ************


// ************ Authentication ************
function setupAuthenticationForms() {
    document.querySelectorAll('.auth-form').forEach((form) => {
        form.addEventListener('submit', (evt) => {
            showSpinner();
            evt.preventDefault();

            let form = evt.target;
            resetFormErrors(form);
            let formData = new FormData(form);
            const xhttp = new XMLHttpRequest();

            xhttp.onloadend = function () {
                if (xhttp.status == 200) {
                    window.location.reload();
                }
                else if (xhttp.status == 422) {
                    displayFormErrors(form, JSON.parse(xhttp.responseText));
                    hideSpinner();
                } else {
                    xhttp.abort();
                    hideSpinner();
                }
            }

            xhttp.open('POST', form.action, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.setRequestHeader('Accept', 'application/json');
            xhttp.send(new URLSearchParams(formData));
        });
    });
}
// ************ /END Authentication ************


// ************ Like ************
function setupLikeButtons() {
    document.querySelectorAll('[data-action="like"]').forEach((button) => {
        button.addEventListener('click', (evt) => {
            showSpinner();
            let targ = evt.target;
            let counterElement = targ.nextElementSibling;
            let counter = counterElement.innerHTML == '' ? 0 : parseInt(counterElement.innerHTML);

            const params = {
                model: targ.dataset.model,
                modelID: targ.dataset.id,
            };

            const xhttp = new XMLHttpRequest();

            xhttp.onloadend = function () {
                if (xhttp.status == 200) {
                    if (xhttp.responseText == 'liked') {
                        targ.classList.add('like__icon--active');
                        counterElement.innerHTML = counter + 1;
                    }

                    if (xhttp.responseText == 'unliked') {
                        targ.classList.remove('like__icon--active');
                        counter--;
                        counterElement.innerHTML = counter > 0 ? counter : '';
                    }
                    hideSpinner();
                } else {
                    xhttp.abort();
                    hideSpinner();
                }
            }

            xhttp.open('POST', '/likes/toggle', true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
        });
    });
}

// ************ /END Like ************


// ************ Favorite ************
function setupFavoriteDropdowns() {
    let list = document.querySelector('.cards-list');

    if (list) {
        list.querySelectorAll('.dropdown__button').forEach((button) => {
            button.addEventListener('click', (evt) => {
                evt.target.closest('.dropdown').classList.toggle('dropdown--active');
            });
        });
    }
}

function setupFavoriteButtons() {
    document.querySelectorAll('[data-action="favorite"]').forEach((button) => {
        button.addEventListener('click', (evt) => {
            showSpinner();
            targ = evt.target;
            let dropdown = targ.closest('.favorite-dropdown');
            let favoriteIcon = dropdown.querySelector('.favorite-icon');

            // get all checked checkboxes values
            let form = targ.closest('.favorite-form');
            let chbList = [];

            form.querySelectorAll('input[type=checkbox]:checked').forEach((chb) => {
                chbList.push(chb.value);
            });

            const params = {
                model: targ.dataset.model,
                modelID: targ.dataset.id,
                folderIDs: chbList
            };

            const xhttp = new XMLHttpRequest();
            xhttp.onloadend = function () {
                if (xhttp.status == 200) {
                    if (xhttp.responseText == 'favorited') {
                        favoriteIcon.classList.add('favorite-icon--active');
                    } else if (xhttp.responseText == 'unfavorited') {
                        favoriteIcon.classList.remove('favorite-icon--active');
                    }
                    hideSpinner()
                } else {
                    xhttp.abort();
                    hideSpinner();
                }
            }

            xhttp.open('POST', '/favorites/toggle', true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.setRequestHeader('Content-type', 'application/json');
            xhttp.send(JSON.stringify(params));
        });
    });
}
// ************ /END Favorite ************

function setupCardShareBtns() {
    const list = document.querySelector('.cards-list');

    if (list) {
        list.querySelectorAll('.ya-share2').forEach((shareDiv) => {
            shareDiv.innerHTML = null;
            Ya.share2(shareDiv, {});
        });
    }
}
