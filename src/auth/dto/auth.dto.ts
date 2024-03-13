import { IsEmail, IsNotEmpty, IsString } from 'class-validator'

export class LoginDto {
  @IsEmail({}, { message: 'Поле должно быть email адресом' })
  @IsNotEmpty({ message: 'Поле "Email" обязательно' })
  email: string

  @IsString({ message: 'Поле "Пароль" должно быть строкой' })
  @IsNotEmpty({ message: 'Поле "Пароль" обязательно' })
  password: string

  @IsNotEmpty({ message: 'Поле "Запомнить меня" обязательно' })
  remember: boolean
}
