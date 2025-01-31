<?php
interface IEntity {
    public static function fromAssoc(array $data): static;
}

interface IVisualEntity extends IEntity {
    public static function imagePath($name): string;
    public function getImagePath(): string;
}
