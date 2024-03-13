/*
  Warnings:

  - You are about to drop the column `workId` on the `seo` table. All the data in the column will be lost.

*/
-- DropForeignKey
ALTER TABLE `seo` DROP FOREIGN KEY `seo_workId_fkey`;

-- AlterTable
ALTER TABLE `seo` DROP COLUMN `workId`,
    ADD COLUMN `work_id` INTEGER NULL;

-- AddForeignKey
ALTER TABLE `seo` ADD CONSTRAINT `seo_work_id_fkey` FOREIGN KEY (`work_id`) REFERENCES `works`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
