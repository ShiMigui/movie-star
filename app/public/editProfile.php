<?php
require_once '../private/url.php';
require_once __PRIVATE . 'manager/funcs/save_image.php';
require_once __PRIVATE . 'manager/funcs/require_login.php';
require_login('Você precisa estar logado para editar seu perfil');

$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$isEdit = isset($_POST['type']) && $_POST['type'] === 'edit';

$image = $login['image'];
$cd = $login['cd'];
$description = '';
$userName = '';
$lastName = '';
$email = '';

try {
    if (!$isEdit) { // Loading user from database
        if (!$user = $userDAO->findById($cd, UserAtt::PROFILE)) throw new Exception('Usuário não encontrado.');
        $user->setCd($cd);
        $description = $user->getDescription();
        $userName = $user->getUserName();
        $lastName = $user->getLastName();
        $image = $user->getImagePath();
        $email = $user->getEmail();
    }
    if ($isPost) {
        if ($isEdit) {
            #region Sanitizing and validating input
            $userName = trim(filter_input(INPUT_POST, 'userName') ?? '');
            $lastName = trim(filter_input(INPUT_POST, 'lastName') ?? '');
            $description = trim(filter_input(INPUT_POST, 'description') ?? '');
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
            if (empty($userName) || empty($lastName) || empty($email)) throw new Exception('Todos os campos devem ser preenchidos.');
            #endregion
            #region Updating user data
            #region Image upload
            if ($file = $_FILES['image'] ?? null) save_image($file, User::imagePath($cd));
            $icImage = $file !== null;
            #endregion
            $user = new User($cd, $icImage, $email, null, $userName, $lastName, null, $description);

            if (!$userDAO->update($user)) throw new Exception('Não foi possível salvar as alterações.');
            $user->setToken($login['token']);
            Auth::login($user, 'Alterações salvas com sucesso.');
            #endregion
        } else {
            #region Sanitizing and validating input
            $password = trim(filter_input(INPUT_POST, 'password') ?? '');
            $confirm = trim(filter_input(INPUT_POST, 'passwordConfirm') ?? '');
            if (empty($password)) throw new Exception('Preencha a senha.');
            #endregion
            #region Updating user password
            $user = new User($cd);
            $user->setPassword($password);
            if (!$userDAO->updatePassword($user)) throw new Exception('Não foi possível salvar as alterações.');
            Alert::save('Senha alterada com sucesso.', AlertType::SUCCESS);
            Auth::logout('auth.php');
            #endregion
        }
    }
} catch (\Throwable $th) {
    Alert::save($th->getMessage(), AlertType::ERROR);
}
require_once __PRIVATE . 'template/header.php';
?>
<main class="limiter-md c-content">
    <?= Alert::loadIf(!$isPost) ?>
    <form action="editProfile.php" method="post" class="form-box c-content fill" enctype="multipart/form-data">
        <h2 class="txt-center">Alterar Perfil</h2>
        <input type="hidden" name="type" value="edit">
        <div class="r-fx-gp ai-end">
            <div class="user-img-lg">
                <img src="<?= $image ?>" alt="Image do usuário">
                <label for="image">Inserir imagem</label><input type="file" id="image" name="image">
            </div>
            <div class="c-content">
                <label for="userName">Nome</label><input type="text" id="userName" name="userName" value="<?= $userName ?>" required>
                <label for="lastName">Sobrenome</label><input type="text" id="lastName" name="lastName" value="<?= $lastName ?>" required>
                <label for="email">E-mail</label><input type="email" id="email" name="email" value="<?= $email ?>" readonly required>
            </div>
        </div>
        <label for="description">Descrição</label><textarea name="description" id="description" rows="10"><?= $description ?></textarea>
        <div class="r-fx-gp jc-center"><button type="reset" class="b-second">Cancelar</button><button type="submit" class="btn">Salvar</button></div>
        <?= Alert::loadIf($isPost && $isEdit) ?>
    </form>

    <form action="editProfile.php" method="post" class="form-box c-content limiter-sm">
        <h2 class="txt-center">Alterar Senha</h2>
        <?php require_once __PRIVATE . 'template/passwordConfirm.php'; ?>
        <div class="r-fx-gp jc-center"><button type="reset" class="b-second">Cancelar</button><button type="submit" class="btn">Salvar</button></div>
        <?= Alert::loadIf($isPost && !$isEdit) ?>
    </form>
</main>
<script src="script/component/previewImage.js" type="module"></script>
<?php require_once __PRIVATE . 'template/footer.php'; ?>