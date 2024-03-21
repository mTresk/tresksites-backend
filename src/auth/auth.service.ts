import { Injectable, UnprocessableEntityException } from '@nestjs/common'
import { PrismaService } from 'src/prisma/prisma.service'
import { LoginDto } from './dto'
import * as bcrypt from 'bcrypt'
import { JwtService } from '@nestjs/jwt'
import { ConfigService } from '@nestjs/config'

@Injectable({})
export class AuthService {
	constructor(
		private readonly prisma: PrismaService,
		private readonly jwtService: JwtService,
		private readonly config: ConfigService,
	) {}

	async login(loginDto: LoginDto, res: any) {
		const user = await this.prisma.user.findUnique({
			where: {
				email: loginDto.email,
			},
		})

		if (!user) {
			throw new UnprocessableEntityException({
				errors: { email: ['Неверный email или пароль'] },
			})
		}

		const hashedPassword = /^\$2y\$/.test(user.password)
			? '$2a$' + user.password.slice(4)
			: user.password

		const passwordMatches = await bcrypt.compare(
			loginDto.password,
			hashedPassword,
		)

		if (!passwordMatches) {
			throw new UnprocessableEntityException({
				errors: { email: ['Неверный email или пароль'] },
			})
		}

		return this.signToken(user.id, user.email, loginDto.remember, res)
	}

	async logout(res: any) {
		const secret = this.config.get('JWT_SECRET')

		await res.cookie('access_token', '', {
			expires: new Date(Date.now()),
			secret: secret,
			sameSite: 'Lax',
			httpOnly: true,
			domain: this.config.get('COOKIE_DOMAIN'),
		})
		return {}
	}

	private async signToken(
		userId: number,
		email: string,
		remember: boolean,
		res: any,
	) {
		const payload = {
			sub: userId,
			email,
		}

		const secret = this.config.get('JWT_SECRET')

		let token: string

		remember
			? (token = await this.jwtService.signAsync(payload, {
					expiresIn: '7d',
				}))
			: (token = await this.jwtService.signAsync(payload, {
					expiresIn: '1h',
				}))

		if (res?.cookie) {
			res.cookie('access_token', token, {
				expires: remember
					? new Date(Date.now() + 7 * 24 * 60 * 60 * 1000)
					: new Date(Date.now() + 3600000),
				secret: secret,
				sameSite: 'Lax',
				httpOnly: true,
				domain: this.config.get('COOKIE_DOMAIN'),
			})
		}

		return {}
	}
}
