import { Module } from '@nestjs/common'
import { OrderService } from './order.service'
import { OrderController } from './order.controller'
import { FileService } from '../file/file.service'
import { MediaService } from '../media/media.service'

@Module({
	controllers: [OrderController],
	providers: [OrderService, FileService, MediaService],
})
export class OrderModule {}
