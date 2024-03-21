import { Module } from '@nestjs/common'
import { ServiceService } from './service.service'
import { ServiceController } from './service.controller'
import { FileService } from '../file/file.service'
import { MediaService } from '../media/media.service'

@Module({
	controllers: [ServiceController],
	providers: [ServiceService, FileService, MediaService],
})
export class ServiceModule {}
