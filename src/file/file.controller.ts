import {
  Controller,
  Delete,
  Get,
  Param,
  Post,
  Query,
  UploadedFile,
  UseInterceptors,
} from '@nestjs/common'
import { FileService } from './file.service'
import { FileInterceptor } from '@nestjs/platform-express'
import { Express } from 'express'

@Controller('files')
export class FileController {
  constructor(private readonly fileService: FileService) {}

  @Get()
  getFile(@Query('url') url: string) {
    return this.fileService.getFile(url)
  }

  @Post('upload')
  @UseInterceptors(FileInterceptor('file'))
  uploadTemporaryFile(@UploadedFile() file: Express.Multer.File) {
    return this.fileService.uploadTemporaryFile(file)
  }

  @Delete('upload/:folder')
  deleteTemporaryFile(@Param('folder') folder: string) {
    return this.fileService.deleteTemporaryFile(folder)
  }
}
