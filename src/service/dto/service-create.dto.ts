import { IsNotEmpty, IsString } from 'class-validator'

export class ServiceCreateDto {
	@IsString({ message: 'Поле "Иконка" должно быть строкой' })
	@IsNotEmpty({ message: 'Поле "Иконка" обязательно' })
	galleryId: string

	@IsNotEmpty({ message: 'Поле "Заголовок" обязательно' })
	title: string

	@IsNotEmpty({ message: 'Поле "Описание" обязательно' })
	description: string
}
