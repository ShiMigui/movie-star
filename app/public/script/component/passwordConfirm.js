import { materialSymbols as iconGroup } from '../modules/icon.js';

const $container = document.getElementById('password-confirm-container');
const $form = $container.parentElement;
const [$password, $passwordConfirm] = $container.querySelectorAll('input[type="password"]');
const $req = {};
document.querySelectorAll('#password-requirements .requirement')
    .forEach($el => $req[$el.dataset.require] = { $el, $icon: $el.querySelector('span') })

const req = {
    chs: (p) => /[!@#$%^&*()\-_+=|\\{}[\]:;"'<>,.?/]/.test(p),
    lyr: (p) => /[A-Za-z]/.test(p),
    num: (p) => /[0-9]/.test(p),
    sam: (p, c = $passwordConfirm.value) => p !== '' && p === c,
}

const pre = {};

const acts = {
    false: ($req) => {
        $req.$el.classList.add('error');
        iconGroup.close($req.$icon);
    },
    true: ($req) => {
        $req.$el.classList.remove('error');
        iconGroup.check($req.$icon);
    },
}

$passwordConfirm.addEventListener('input', (e) => {
    const ic = pre.sam = req.sam($password.value);
    acts[ic]($req.sam);
})

$password.addEventListener('input', (e) => {
    const value = $password.value;
    for (let key in req) {
        const ic = pre[key] = req[key](value);
        acts[ic]($req[key]);
    }
})

$form.addEventListener('submit', (e) => {
    if (pre.sam && pre.chs && pre.lyr && pre.num) return; // Proceed with normal form submission
    alert('Verifique os requerimentos de senha');
    e.preventDefault();
})