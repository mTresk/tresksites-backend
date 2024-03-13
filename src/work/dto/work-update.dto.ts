import {
  IsBoolean,
  IsNotEmpty,
  IsOptional,
  IsString,
  IsArray,
} from 'class-validator'

export class WorkUpdateDto {
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
  content?: {
    data?: {
      html?: string
      images?: {
        image: string
      }
      galleryId?: string
    }
  }

  @IsBoolean({ message: 'Поле "Содержимое" должно быть булевым значением' })
  @IsNotEmpty({ message: 'Поле "В подборке" обязательно' })
  isFeatured: boolean

  @IsString({ message: 'Поле "Изображение" должно быть строкой' })
  @IsOptional()
  galleryId: string

  @IsOptional()
  seo: {
    title?: string
    description?: string
  }
}
