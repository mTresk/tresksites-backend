import {
  IsBoolean,
  IsNotEmpty,
  IsOptional,
  IsString,
  IsArray,
} from 'class-validator'
import { Prisma } from '@prisma/client'

export class WorkCreateDto {
  @IsNotEmpty({ message: 'Поле "Название" обязательно' })
  @IsString({ message: 'Поле "Название" должно быть строкой' })
  name: string

  @IsNotEmpty({ message: 'Поле "Слаг" обязательно' })
  @IsString({ message: 'Поле "Слаг" должно быть строкой' })
  slug: string

  @IsString({ message: 'Поле "Лейбл" должно быть строкой' })
  @IsOptional()
  label: string

  @IsString({ message: 'Поле "Лейбл" должно быть строкой' })
  @IsOptional()
  url: string

  @IsString({ message: 'Поле "Список" должно быть строкой' })
  @IsOptional()
  list: string

  @IsArray()
  content?: Prisma.JsonArray

  @IsBoolean({ message: 'Поле "Содержимое" должно быть булевым значением' })
  @IsNotEmpty({ message: 'Поле "В подборке" обязательно' })
  isFeatured: boolean

  @IsString({ message: 'Поле "Изображение" должно быть строкой' })
  @IsNotEmpty({ message: 'Поле "Изображение" обязательно' })
  galleryId: string
}
