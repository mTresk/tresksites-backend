import { IsNotEmpty, IsOptional, IsString } from 'class-validator'

export class ServiceUpdateDto {
  @IsString({ message: 'Поле "Файл" должно быть строкой' })
  @IsOptional()
  url: string

  @IsNotEmpty({ message: 'Поле "Заголовок" обязательно' })
  title: string

  @IsNotEmpty({ message: 'Поле "описание" обязательно' })
  description: string
}
