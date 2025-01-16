CREATE TABLE `Hero`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `url_image` VARCHAR(255) NOT NULL,
    `isDead` BOOLEAN NOT NULL DEFAULT '0',
    `level` BIGINT NOT NULL DEFAULT '1'
);
CREATE TABLE `Competence`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `base_damage` BIGINT NOT NULL,
    `cooldown` BIGINT NOT NULL,
    `level` INT NOT NULL
);
CREATE TABLE `Hero_Competence`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_hero` BIGINT NOT NULL,
    `id_competence` BIGINT NOT NULL
);
CREATE TABLE `HeroStat`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_hero` BIGINT NOT NULL,
    `stat_name` VARCHAR(255) NOT NULL,
    `stat_value` BIGINT NOT NULL
);
CREATE TABLE `CompetenceMultiplier`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_competence` BIGINT NOT NULL,
    `stat_name` VARCHAR(255) NOT NULL,
    `multiplier` FLOAT(53) NOT NULL
);
ALTER TABLE
    `Hero_Competence` ADD CONSTRAINT `hero_competence_id_hero_foreign` FOREIGN KEY(`id_hero`) REFERENCES `Hero`(`id`);
ALTER TABLE
    `CompetenceMultiplier` ADD CONSTRAINT `competencemultiplier_id_competence_foreign` FOREIGN KEY(`id_competence`) REFERENCES `Competence`(`id`);
ALTER TABLE
    `Hero_Competence` ADD CONSTRAINT `hero_competence_id_competence_foreign` FOREIGN KEY(`id_competence`) REFERENCES `Competence`(`id`);
ALTER TABLE
    `HeroStat` ADD CONSTRAINT `herostat_id_hero_foreign` FOREIGN KEY(`id_hero`) REFERENCES `Hero`(`id`);