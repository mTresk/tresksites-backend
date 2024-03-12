import { Body, Controller, Get, Put } from '@nestjs/common'
import { PolicyService } from './policy.service'
import { PolicyDto } from './dto'

@Controller('policy')
export class PolicyController {
  constructor(private readonly policyService: PolicyService) {}

  @Get()
  findFirst() {
    return this.policyService.findFirst()
  }

  @Put('update')
  update(@Body() policyDto: PolicyDto) {
    return this.policyService.update(policyDto)
  }
}
