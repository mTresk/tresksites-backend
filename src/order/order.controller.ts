import {
  Body,
  Controller,
  Delete,
  Get,
  HttpStatus,
  Param,
  ParseFilePipeBuilder,
  ParseIntPipe,
  Post,
  UploadedFile,
  UseGuards,
  UseInterceptors,
} from '@nestjs/common'
import { OrderService } from './order.service'
import { OrderDto } from './dto'
import { FileInterceptor } from '@nestjs/platform-express'
import { Express } from 'express'
import { FileService } from '../file/file.service'
import { JwtGuard, RolesGuard } from '../auth/guard'

@Controller('orders')
export class OrderController {
  constructor(
    private readonly orderService: OrderService,
    private readonly fileService: FileService,
  ) {}

  @UseGuards(JwtGuard, RolesGuard)
  @Get()
  findAll() {
    return this.orderService.findAll()
  }

  @UseGuards(JwtGuard, RolesGuard)
  @Get(':id')
  findOne(@Param('id', ParseIntPipe) id: number) {
    return this.orderService.findOne(id)
  }

  @Post()
  @UseInterceptors(FileInterceptor('attachment'))
  async create(
    @UploadedFile(
      new ParseFilePipeBuilder()
        .addMaxSizeValidator({
          maxSize: 1000000,
        })
        .build({
          errorHttpStatusCode: HttpStatus.UNPROCESSABLE_ENTITY,
          fileIsRequired: false,
        }),
    )
    attachment: Express.Multer.File,
    @Body() orderDto: OrderDto,
  ) {
    let fileName: string

    if (attachment) {
      fileName = await this.fileService.saveAttachment(attachment)
    }

    return this.orderService.create(orderDto, fileName)
  }

  @UseGuards(JwtGuard, RolesGuard)
  @Delete(':id')
  remove(@Param('id', ParseIntPipe) id: number) {
    return this.orderService.remove(id)
  }
}
