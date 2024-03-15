import { IsNumber, IsOptional } from 'class-validator'
import { Type } from 'class-transformer'

export class WorkQueryDto {
  @Type(() => Number)
  @IsNumber()
  @IsOptional()
  page?: number

  @Type(() => Number)
  @IsNumber()
  @IsOptional()
  perPage?: number
}
