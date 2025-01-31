/**
 * Function to hide an HTML element
 * @param {HTMLElement} $el The HTML element to hide
 */
const hide = ($el) => $el.classList.add('hidden');

/**
 * Function to show an HTML element
 * @param {HTMLElement} $el The HTML element to show
 */
const show = ($el) => $el.classList.remove('hidden');

/**
 * Function to toggle the visibility of an HTML element
 * @param {HTMLElement} $el The HTML element to toggle
 */
const toggle = ($el) => $el.classList.toggle('hidden');

export default { hide, show, toggle };