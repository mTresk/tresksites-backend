-- AlterTable
ALTER TABLE `media` ADD COLUMN `contact_id` INTEGER NULL;

-- AddForeignKey
ALTER TABLE `media` ADD CONSTRAINT `media_contact_id_fkey` FOREIGN KEY (`contact_id`) REFERENCES `contacts`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
