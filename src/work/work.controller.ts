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
import { WorkService } from './work.service'
import { WorkCreateDto } from './dto'
import { WorkUpdateDto } from './dto/work-update.dto'

@Controller('works')
export class WorkController {
  constructor(private readonly workService: WorkService) {}

  @Get()
  findAll() {
    return this.workService.findAll()
  }

  @Get(':id')
  findOne(@Param('id', ParseIntPipe) id: number) {
    return this.workService.findOne(id)
  }

  @Post()
  create(@Body() workDto: WorkCreateDto) {
    return this.workService.create(workDto)
  }

  @Put(':id')
  update(
    @Param('id', ParseIntPipe) id: number,
    @Body() workDto: WorkUpdateDto,
  ) {
    return this.workService.update(id, workDto)
  }

  @Delete(':id')
  remove(@Param('id', ParseIntPipe) id: number) {
    return this.workService.remove(id)
  }
}
