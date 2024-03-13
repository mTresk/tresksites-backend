import { Body, Controller, Get, Put, UseGuards } from '@nestjs/common'
import { PriceService } from './price.service'
import { PriceDto } from './dto'
import { JwtGuard, RolesGuard } from '../auth/guard'

@Controller('prices')
export class PriceController {
  constructor(private readonly priceService: PriceService) {}

  @Get()
  findFirst() {
    return this.priceService.findFirst()
  }

  @UseGuards(JwtGuard, RolesGuard)
  @Put('update')
  update(@Body() priceDto: PriceDto) {
    return this.priceService.update(priceDto)
  }
}
