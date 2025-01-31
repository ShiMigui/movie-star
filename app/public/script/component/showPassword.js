import { materialSymbols as iconGroup } from '../modules/icon.js';
const act = {
    true: ($btn, $inp) => {
        $inp.type = 'text';
        iconGroup.visibility_off($btn);
    },
    false: ($btn, $inp) => {
        $inp.type = 'password';
        iconGroup.visibility($btn);
    },
}

document.querySelectorAll('.show-password').forEach($el => {
    const $inp = $el.parentElement.querySelector('input[type="password"]');

    $el.addEventListener('click', () => act[$inp.type === 'password']($el, $inp));
})