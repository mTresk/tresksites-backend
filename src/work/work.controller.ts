import {
	Body,
	Controller,
	Delete,
	Get,
	Param,
	Post,
	Put,
	Query,
	UseGuards,
} from '@nestjs/common'
import { WorkService } from './work.service'
import { WorkCreateDto, WorkQueryDto, WorkUpdateDto } from './dto'
import { JwtGuard, RolesGuard } from '../auth/guard'

@Controller('works')
export class WorkController {
	constructor(private readonly workService: WorkService) {}

	@Get()
	findAll(@Query() { page, perPage }: WorkQueryDto) {
		return this.workService.findAll(page, perPage)
	}

	@Get('featured')
	findFeatured() {
		return this.workService.findFeatured()
	}

	@Get(':slug')
	findOne(@Param('slug') slug: string) {
		return this.workService.findOne(slug)
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Post()
	create(@Body() workDto: WorkCreateDto) {
		return this.workService.create(workDto)
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Put(':slug')
	update(@Param('slug') slug: string, @Body() workDto: WorkUpdateDto) {
		return this.workService.update(slug, workDto)
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Delete(':slug')
	remove(@Param('slug') slug: string) {
		return this.workService.remove(slug)
	}
}
