import { IsArray, IsNotEmpty, IsOptional, IsString } from 'class-validator'

export class PriceDto {
  @IsString({ message: 'Поле "Заголовок" должно быть строкой' })
  @IsNotEmpty({ message: 'Поле "Заголовок" обязательно' })
  title: string

  @IsString({ message: 'Поле "Описание" должно быть строкой' })
  @IsOptional()
  description?: string

  @IsArray()
  @IsOptional()
  block?: {
    service?: string
    price?: string
  }
}
