import {
	Body,
	Controller,
	Delete,
	Get,
	Param,
	ParseIntPipe,
	Post,
	Put,
	UseGuards,
} from '@nestjs/common'
import { ServiceService } from './service.service'
import { ServiceCreateDto, ServiceUpdateDto } from './dto'
import { JwtGuard, RolesGuard } from '../auth/guard'

@Controller('services')
export class ServiceController {
	constructor(private readonly serviceService: ServiceService) {}

	@Get()
	findAll() {
		return this.serviceService.findAll()
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Get(':id')
	findOne(@Param('id', ParseIntPipe) id: number) {
		return this.serviceService.findOne(id)
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Post()
	create(@Body() serviceDto: ServiceCreateDto) {
		return this.serviceService.create(serviceDto)
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Put(':id')
	update(
		@Param('id', ParseIntPipe) id: number,
		@Body() serviceDto: ServiceUpdateDto,
	) {
		return this.serviceService.update(id, serviceDto)
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Delete(':id')
	remove(@Param('id', ParseIntPipe) id: number) {
		return this.serviceService.remove(id)
	}
}
