import { Body, Controller, Get, Put, UseGuards } from '@nestjs/common'
import { PolicyService } from './policy.service'
import { PolicyDto } from './dto'
import { JwtGuard, RolesGuard } from '../auth/guard'

@Controller('policy')
export class PolicyController {
	constructor(private readonly policyService: PolicyService) {}

	@Get()
	findFirst() {
		return this.policyService.findFirst()
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Put('update')
	update(@Body() policyDto: PolicyDto) {
		return this.policyService.update(policyDto)
	}
}
