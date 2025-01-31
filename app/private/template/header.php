<?php require_once __PRIVATE . 'template/head.php'; ?>
<header>
    <section class="limiter-lg r-fx-gp jc-between ai-center">
        <a href="/" class="logo">
            <img src="img/logo.svg" alt="Logotipo do site, Movie star">
            <h1>Movie Star</h1>
        </a>

        <form action="search.php" method="get" class="element-joiner"><input type="text" name="query" required><button type="submit" class="b-third material-symbols-outlined">search</button></form>

        <nav>
            <ul class="r-fx-gp ai-center">
                <?php if ($login): ?>
                    <li class="r-fx ai-center" id="active-dropdown"><img class="user-img-sm" src="<?= $login['image'] ?>" alt="User image"><?= $login['name'] ?><span class="material-symbols-outlined">arrow_drop_down</span></li>

                    <nav id="dropdown" class="hidden">
                        <ul class="c-fx">
                            <li><a href="profile.php">Meu Perfil<span class="material-symbols-outlined">account_circle</span></a></li>
                            <li><a href="logout.php">Sair<span class="material-symbols-outlined">exit_to_app</span></a></li>
                        </ul>
                    </nav>
                    <script src="script/component/dropdown.js" type="module" defer></script>
                <?php else: ?>
                    <li><a href="auth.php">Login / Cadastro<span class="material-symbols-outlined">login</span></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </section>
</header>