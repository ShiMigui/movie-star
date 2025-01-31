const $inpFile = document.getElementById('image');
const $preview = $inpFile.parentElement.querySelector('img');

$inpFile.addEventListener('change', function () {
    if (!this.files || !this.files[0]) return;
    $preview.src = URL.createObjectURL(this.files[0]);
});