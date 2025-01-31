import visibility from '../modules/visibility.js';

const $dropdown = document.getElementById('dropdown');

document.getElementById('active-dropdown').addEventListener('click', () => visibility.toggle($dropdown));