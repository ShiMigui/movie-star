<div class="c-content" id="password-confirm-container">
    <label for="password">Senha</label>
    <div class="element-joiner">
        <input type="password" id="password" name="password" minlength="8" required>
        <button type="button" class="material-symbols-outlined b-third show-password">visibility</button>
    </div>
    <label for="passwordConfirm">Confirme a senha</label>
    <div class="element-joiner">
        <input type="password" id="passwordConfirm" name="passwordConfirm" minlength="8" required>
        <button type="button" class="material-symbols-outlined b-third show-password">visibility</button>
    </div>
    <div id="password-requirements">
        <div class="requirement error" data-require="lyr">Ao menos uma letra.<span class="material-symbols-outlined">close</span></div>
        <div class="requirement error" data-require="num">Ao menos um número.<span class="material-symbols-outlined">close</span></div>
        <div class="requirement error" data-require="chs">Ao menos um carecter especial.<span class="material-symbols-outlined">close</span></div>
        <div class="requirement error" data-require="sam">Senha devem ser iguais.<span class="material-symbols-outlined">close</span></div>
    </div>
</div>
<script src="script/component/passwordConfirm.js" type="module" defer></script>
<script src="script/component/showPassword.js" type="module" defer></script>