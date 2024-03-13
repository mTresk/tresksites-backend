import {
  Body,
  Controller,
  Delete,
  Get,
  Param,
  Post,
  Put,
  Query,
} from '@nestjs/common'
import { WorkService } from './work.service'
import { WorkCreateDto, WorkUpdateDto } from './dto'

@Controller('works')
export class WorkController {
  constructor(private readonly workService: WorkService) {}

  @Get()
  findAll(@Query() query: any) {
    return this.workService.findAll(query)
  }

  @Get('featured')
  findFeatured() {
    return this.workService.findFeatured()
  }

  @Get(':slug')
  findOne(@Param('slug') slug: string) {
    return this.workService.findOne(slug)
  }

  @Post()
  create(@Body() workDto: WorkCreateDto) {
    return this.workService.create(workDto)
  }

  @Put(':slug')
  update(@Param('slug') slug: string, @Body() workDto: WorkUpdateDto) {
    return this.workService.update(slug, workDto)
  }

  @Delete(':slug')
  remove(@Param('slug') slug: string) {
    return this.workService.remove(slug)
  }
}
