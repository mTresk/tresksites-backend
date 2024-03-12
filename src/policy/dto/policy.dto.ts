import { IsNotEmpty, IsString } from 'class-validator'

export class PolicyDto {
  @IsString({ message: 'Поле "Содержимое" должно быть строкой' })
  @IsNotEmpty({ message: 'Поле "Содержимое" обязательно' })
  content: string
}
