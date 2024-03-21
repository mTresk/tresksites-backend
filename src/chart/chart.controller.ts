import { Controller, Get, UseGuards } from '@nestjs/common'
import { ChartService } from './chart.service'
import { JwtGuard, RolesGuard } from '../auth/guard'

@UseGuards(JwtGuard, RolesGuard)
@Controller('chart')
export class ChartController {
	constructor(private readonly chartService: ChartService) {}

	@Get('stats')
	stats() {
		return this.chartService.getStats()
	}
}
