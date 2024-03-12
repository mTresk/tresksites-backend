import { IsArray, IsNotEmpty, IsOptional, IsString } from 'class-validator'

export class ContactsDto {
  @IsString({ message: 'Поле "Имя" должно быть строкой' })
  @IsNotEmpty({ message: 'Поле "Имя" обязательно' })
  name: string

  @IsString({ message: 'Поле "ИНН" должно быть строкой' })
  @IsOptional()
  inn?: string

  @IsString({ message: 'Поле "Email" должно быть строкой' })
  @IsOptional()
  email?: string

  @IsString({ message: 'Поле "Телеграм" должно быть строкой' })
  @IsOptional()
  telegram?: string

  @IsArray()
  @IsOptional()
  block?: {
    content?: string
  }

  @IsString({ message: 'Поле "Бриф" должно быть строкой' })
  @IsOptional()
  galleryId?: string
}
