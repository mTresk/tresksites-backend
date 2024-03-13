-- DropForeignKey
ALTER TABLE `seo` DROP FOREIGN KEY `seo_work_id_fkey`;

-- AddForeignKey
ALTER TABLE `seo` ADD CONSTRAINT `seo_work_id_fkey` FOREIGN KEY (`work_id`) REFERENCES `works`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
