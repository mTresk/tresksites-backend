import { ExtractJwt, Strategy } from 'passport-jwt'
import { PassportStrategy } from '@nestjs/passport'
import { Injectable } from '@nestjs/common'
import { PrismaService } from 'src/prisma/prisma.service'
import { Request as RequestType } from 'express'
import { ConfigService } from '@nestjs/config'

@Injectable()
export class JwtStrategy extends PassportStrategy(Strategy, 'jwt') {
	constructor(
		private readonly prisma: PrismaService,
		config: ConfigService,
	) {
		super({
			jwtFromRequest: ExtractJwt.fromExtractors([
				JwtStrategy.extractJWT,
				ExtractJwt.fromAuthHeaderAsBearerToken(),
			]),
			secretOrKey: config.get('JWT_SECRET_KEY'),
		})
	}

	private static extractJWT(req: RequestType): string | null {
		if (
			req.cookies &&
			'access_token' in req.cookies &&
			req.cookies.access_token.length > 0
		) {
			return req.cookies.access_token
		}
		return null
	}

	async validate(payload: { sub: number; email: string }) {
		const user = await this.prisma.user.findUnique({
			where: {
				id: payload.sub,
			},
		})

		delete user.password

		return user
	}
}
