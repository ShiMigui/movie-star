function materialSymbolsFactory(name) {
    /**
     * Function to sets a Google Icon element
     * @param {HTMLElement} $el The HTML element to set the Google Icon
     */
    return ($el) => $el.innerText = name;
}

export const materialSymbols = {
    visibility_off: materialSymbolsFactory('visibility_off'),
    visibility: materialSymbolsFactory('visibility'),
    close: materialSymbolsFactory('close'),
    check: materialSymbolsFactory('check'),
}