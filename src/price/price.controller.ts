import { Body, Controller, Get, Put } from '@nestjs/common'
import { PriceService } from './price.service'
import { PriceDto } from './dto'

@Controller('prices')
export class PriceController {
  constructor(private readonly priceService: PriceService) {}

  @Get()
  findFirst() {
    return this.priceService.findFirst()
  }

  @Put('update')
  update(@Body() priceDto: PriceDto) {
    return this.priceService.update(priceDto)
  }
}
