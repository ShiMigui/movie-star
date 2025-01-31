<?php
require_once '../private/url.php';

if ($login) Auth::redirect();

$email = '';
$password = '';
$userName = '';
$lastName = '';
$destiny = $_GET['destiny'] ?? '/';

$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$isRegister = isset($_POST['type']) && $_POST['type'] === 'register';
try {
    if ($isPost) {
        #region Email and password data input
        $email = trim(filter_input(INPUT_POST, 'email') ?? '');
        $password = trim(filter_input(INPUT_POST, 'password') ?? '');
        if (empty($email) || empty($password)) throw new Exception('Preencha todos os campos.');
        #endregion
        if (!$isRegister) {
            $user = $userDAO->findByEmail($email);
            if (!$user || !password_verify($password, $user->getPassword())) throw new Exception('E-mail ou senha inválidos.');
            $userDAO->updateToken($user);
            Auth::loginRedirect($user, 'Login efetuado com sucesso!', $destiny);
        }
        #region Register user
        #region User data input
        $userName = trim(filter_input(INPUT_POST, 'userName') ?? '');
        $lastName = trim(filter_input(INPUT_POST, 'lastName') ?? '');
        if (empty($userName) || empty($lastName)) throw new Exception('Preencha todos os campos.');
        #endregion
        $user = new User(null, false, $email, null, $userName, $lastName, $password);
        if (!$userDAO->save($user)) throw new Exception('Não foi possível cadastrar o usuário.');
        Auth::loginRedirect($user, 'Usuário cadastrado com sucesso!', $destiny);
        #endregion
    }
} catch (Exception $e) {
    $msg = $e->getCode() === 1062 ? 'E-mail já cadastrado' : $e->getMessage();
    Alert::save($msg, AlertType::ERROR);
} catch (\Throwable $th) {
    Alert::save($th->getMessage(), AlertType::ERROR);
}

require_once __PRIVATE . 'template/header.php';
?>
<main class="limiter-md c-content">
    <?= Alert::loadIf(!$isPost) ?>
    <section class="r-fx-gp jc-between">
        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" class="form-box c-content fill">
            <h2 class="rw-center">Entrar</h2>
            <label for="login-email">E-mail</label><input type="email" id="login-email" name="email" value="<?= $email ?>" required>
            <label for="login-password">Senha</label>
            <div class="element-joiner">
                <input type="password" id="login-password" name="password" required>
                <button type="button" class="material-symbols-outlined b-third show-password">visibility</button>
            </div>
            <div class="r-fx-gp jc-center"><button type="reset" class="b-second">Cancelar</button><button type="submit" class="btn">Entrar</button></div>
            <?= Alert::loadIf($isPost && !$isRegister) ?>
        </form>

        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" class="form-box c-content fill">
            <h2 class="rw-center">Cadastrar</h2>
            <input type="hidden" name="type" value="register">
            <label for="email">E-mail</label><input type="email" id="email" name="email" value="<?= $email ?>" required>
            <label for="userName">Nome</label><input type="text" id="userName" name="userName" value="<?= $userName ?>" required>
            <label for="lastName">Sobrenome</label><input type="text" id="lastName" name="lastName" value="<?= $lastName ?>" required>
            <?php require_once __PRIVATE . 'template/passwordConfirm.php'; ?>
            <div class="r-fx-gp jc-center"><button type="reset" class="b-second">Cancelar</button><button type="submit" class="btn">Cadastrar</button></div>
            <?= Alert::loadIf($isPost && $isRegister) ?>
        </form>
    </section>
</main>
<?php require_once __PRIVATE . 'template/footer.php'; ?>