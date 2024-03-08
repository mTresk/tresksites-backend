import {
  Body,
  Controller,
  Delete,
  Get,
  Param,
  ParseIntPipe,
  Post,
  Put,
} from '@nestjs/common'
import { ServiceService } from './service.service'
import { ServiceCreateDto } from './dto'
import { ServiceUpdateDto } from './dto/service-update.dto'

@Controller('services')
export class ServiceController {
  constructor(private readonly serviceService: ServiceService) {}

  @Get()
  findAll() {
    return this.serviceService.findAll()
  }

  @Get(':id')
  findOne(@Param('id', ParseIntPipe) id: number) {
    return this.serviceService.findOne(id)
  }

  @Post()
  create(@Body() serviceDto: ServiceCreateDto) {
    return this.serviceService.create(serviceDto)
  }

  @Put(':id')
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() serviceDto: ServiceUpdateDto,
  ) {
    return this.serviceService.update(id, serviceDto)
  }

  @Delete(':id')
  remove(@Param('id', ParseIntPipe) id: number) {
    return this.serviceService.remove(id)
  }
}
