import { IsNotEmpty, IsOptional, IsString } from 'class-validator'

export class ServiceUpdateDto {
	@IsString({ message: 'Поле "Иконка" должно быть строкой' })
	@IsOptional()
	galleryId: string

	@IsNotEmpty({ message: 'Поле "Заголовок" обязательно' })
	title: string

	@IsNotEmpty({ message: 'Поле "Описание" обязательно' })
	description: string
}
