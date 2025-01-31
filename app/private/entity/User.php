<?php
require_once __PRIVATE . 'abstract/Entity.php';
class User  implements IVisualEntity  {
    private ?int $cd;
    private bool $icImage;
    private ?string $email;
    private ?string $token;
    private ?string $userName;
    private ?string $lastName;
    private ?string $password;
    private ?string $description;

    public function __construct(
        ?int $cd = null,
        bool $icImage = false,
        ?string $email = null,
        ?string $token = null,
        ?string $userName = null,
        ?string $lastName = null,
        ?string $password = null,
        ?string $description = null
    ) {
        $this->cd = $cd;
        $this->email = $email;
        $this->token = $token;
        $this->icImage = $icImage;
        $this->userName = $userName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->description = $description;
    }

    #region Getters and Setters
    public function getCd(): ?int { return $this->cd; }
    public function hasImage(): bool { return $this->icImage; }
    public function getEmail(): ?string { return $this->email; }
    public function getToken(): ?string { return $this->token; }
    public function getUserName(): ?string { return $this->userName; }
    public function getLastName(): ?string { return $this->lastName; }
    public function getPassword(): ?string { return $this->password; }
    public function getDescription(): ?string { return $this->description; }

    public function getImagePath(): string { return ($this->icImage)? self::imagePath($this->cd): 'img/user/default.png'; }

    public function setCd(int $cd): void { $this->cd = $cd; }
    public function setImage(bool $ic): void { $this->icImage = $ic; }
    public function setEmail(string $str): void { $this->email = $str; }
    public function setToken(string $str): void { $this->token = $str; }
    public function setUserName(string $str): void { $this->userName = $str; }
    public function setLastName(string $str): void { $this->lastName = $str; }
    public function setPassword(string $str): void { $this->password = $str; }
    public function setDescription(string $str): void { $this->description = $str; }
    #endregion

    #region Image methods
    public static function imagePath($name): string { return "img/user/$name.jpg"; }
    #endregion

    #region Assoc methods
    public static function fromAssoc(array $data): static {
        return new static(
            $data['cd_user'] ?? null,
            $data['ic_image'] ?? false,
            $data['nm_email'] ?? null,
            $data['nm_token'] ?? null,
            $data['nm_user_name'] ?? null,
            $data['nm_last_name'] ?? null,
            $data['nm_password'] ?? null,
            $data['ds_user'] ?? null
        );
    }
    #endregion
}
