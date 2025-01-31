<?php
require_once __PRIVATE . 'manager/funcs/gen_token.php';
require_once __PRIVATE . 'abstract/DAO.php';
require_once __PRIVATE . 'entity/User.php';

enum UserAtt: string {
    case ALL = '*';
    case PROFILE = 'nm_user_name,nm_last_name,nm_email,ic_image,ds_user';
    case AUTH = 'cd_user,nm_user_name,ic_image,nm_token';
    case LOGIN = 'cd_user,nm_user_name,ic_image,nm_token,nm_password';
}

class userDAO {
    use TDao;
    public function findById(int $id, UserAtt $att = UserAtt::ALL): ?User {
        return $this->mountUser($this->prepareQuery('i', "SELECT $att->value FROM users WHERE cd_user=?", [$id]));
    }
    public function findByEmail(string $email, UserAtt $att = UserAtt::ALL): ?User {
        return $this->mountUser($this->prepareQuery('s', "SELECT $att->value FROM users WHERE nm_email=?", [$email]));
    }
    public function updateToken(User $user): bool {
        return $this->execQuery(
            'si',
            'UPDATE users SET nm_token=? WHERE cd_user=?',
            [$this->generateToken($user), $user->getCd()]
        );
    }
    public function updatePassword(User $user): bool {
        return $this->execQuery(
            'si',
            'UPDATE users SET nm_password=? WHERE cd_user=?',
            [$this->hashPassword($user), $user->getCd()]
        );
    }
    public function updateProfile(User $user): bool {
        #region User data
        $icImage = $user->hasImage() ? 1 : 0;
        $userName = $user->getUserName();
        $lastName = $user->getLastName();
        $ds = $user->getDescription();
        $cd = $user->getCd();
        #endregion
        return $this->execQuery(
            'ssisi',
            'UPDATE users SET nm_user_name=?,nm_last_name=?,ic_image=?,ds_user=? WHERE cd_user=?',
            [$userName, $lastName, $icImage, $ds, $cd]
        );
    }
    public function save(User $user): bool {
        #region user data
        $password = $this->hashPassword($user);
        $token = $this->generateToken($user);
        $userName = $user->getUserName();
        $lastName = $user->getLastName();
        $email = $user->getEmail();
        #endregion
        $stmt = $this->prepareQuery(
            'sssss',
            'INSERT INTO users(nm_email,nm_user_name,nm_last_name,nm_password,nm_token) VALUES (?,?,?,?,?)',
            [$email, $userName, $lastName, $password, $token]
        );

        if (!$stmt->execute() || $stmt->affected_rows === 0) return false;
        $user->setCd($stmt->insert_id);
        return true;
    }
    private function mountUser(mysqli_stmt $stmt): ?User {
        if ($stmt->execute() && ($result = $stmt->get_result()) && $assoc = $result->fetch_assoc())
            return User::fromAssoc($assoc);
        return null;
    }
    private function generateToken(User $user): string {
        $user->setToken(gen_token(30));
        return $user->getToken();
    }
    private function hashPassword(User $user): string {
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
        return $user->getPassword();
    }
}
