import { Module } from '@nestjs/common'
import { WorkService } from './work.service'
import { WorkController } from './work.controller'
import { MediaService } from '../media/media.service'
import { FileService } from '../file/file.service'

@Module({
  controllers: [WorkController],
  providers: [WorkService, FileService, MediaService],
})
export class WorkModule {}
