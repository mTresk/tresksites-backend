/*
  Warnings:

  - You are about to drop the column `order_id` on the `media` table. All the data in the column will be lost.

*/
-- DropForeignKey
ALTER TABLE `media` DROP FOREIGN KEY `media_order_id_fkey`;

-- AlterTable
ALTER TABLE `media` DROP COLUMN `order_id`;

-- AlterTable
ALTER TABLE `orders` ADD COLUMN `attachment` VARCHAR(255) NULL;
