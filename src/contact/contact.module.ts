import { Module } from '@nestjs/common'
import { ContactService } from './contact.service'
import { ContactController } from './contact.controller'
import { MediaService } from '../media/media.service'
import { FileService } from '../file/file.service'

@Module({
  controllers: [ContactController],
  providers: [ContactService, FileService, MediaService],
})
export class ContactModule {}
