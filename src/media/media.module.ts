import { Module } from '@nestjs/common'
import { MediaService } from './media.service'
import { FileService } from '../file/file.service'

@Module({
	providers: [MediaService, FileService],
	exports: [MediaService],
})
export class MediaModule {}
