/*
  Warnings:

  - A unique constraint covering the columns `[slug]` on the table `works` will be added. If there are existing duplicate values, this will fail.

*/
-- CreateTable
CREATE TABLE `seo` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `created_at` DATETIME(3) NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updated_at` DATETIME(3) NULL,
    `workId` INTEGER NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateIndex
CREATE UNIQUE INDEX `works_slug_key` ON `works`(`slug`);

-- AddForeignKey
ALTER TABLE `seo` ADD CONSTRAINT `seo_workId_fkey` FOREIGN KEY (`workId`) REFERENCES `works`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
