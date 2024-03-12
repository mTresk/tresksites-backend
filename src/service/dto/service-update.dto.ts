import { IsNotEmpty, IsString } from 'class-validator'

export class ServiceUpdateDto {
  @IsString({ message: 'Поле "Иконка" должно быть строкой' })
  @IsNotEmpty({ message: 'Поле "Иконка" обязательно' })
  galleryId: string

  @IsNotEmpty({ message: 'Поле "Заголовок" обязательно' })
  title: string

  @IsNotEmpty({ message: 'Поле "описание" обязательно' })
  description: string
}
