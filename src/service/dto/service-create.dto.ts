import { IsNotEmpty, IsString } from 'class-validator'

export class ServiceCreateDto {
  @IsString({ message: 'Поле "Файл" должно быть строкой' })
  @IsNotEmpty({ message: 'Поле "Файл" обязательно' })
  url: string

  @IsNotEmpty({ message: 'Поле "Заголовок" обязательно' })
  title: string

  @IsNotEmpty({ message: 'Поле "описание" обязательно' })
  description: string
}
