import { IsNotEmpty, IsOptional, IsString } from 'class-validator'

export class ServiceUpdateDto {
  @IsString({ message: 'Поле "Иконка" должно быть строкой' })
  @IsOptional()
  icon: string

  @IsNotEmpty({ message: 'Поле "Заголовок" обязательно' })
  title: string

  @IsNotEmpty({ message: 'Поле "описание" обязательно' })
  description: string
}
