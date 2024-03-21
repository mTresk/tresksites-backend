import { IsNotEmpty, IsOptional, IsString } from 'class-validator'

export class OrderDto {
	@IsString({ message: 'Поле "Имя" должно быть строкой' })
	@IsNotEmpty({ message: 'Поле "Имя" обязательно' })
	name: string

	@IsString({ message: 'Поле "Телефон" должно быть строкой' })
	@IsNotEmpty({ message: 'Поле "Телефон" обязательно' })
	phone: string

	@IsString({ message: 'Поле "Email" должно быть строкой' })
	@IsOptional()
	email: string

	@IsString({ message: 'Поле "Сообщение" должно быть строкой' })
	@IsOptional()
	message: string

	@IsOptional()
	attachment: string
}
