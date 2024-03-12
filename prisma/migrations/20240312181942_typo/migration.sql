/*
  Warnings:

  - You are about to drop the column `gallery_id_at` on the `works` table. All the data in the column will be lost.

*/
-- AlterTable
ALTER TABLE `works` DROP COLUMN `gallery_id_at`,
    ADD COLUMN `gallery_id` VARCHAR(191) NULL;
