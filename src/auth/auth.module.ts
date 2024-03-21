import { Module } from '@nestjs/common'
import { AuthController } from './auth.controller'
import { AuthService } from './auth.service'
import { JwtModule } from '@nestjs/jwt'
import { JwtStrategy } from './strategy'
import { ConfigService } from '@nestjs/config'

@Module({
	imports: [
		JwtModule.registerAsync({
			useFactory: (config: ConfigService) => {
				return {
					secret: config.get('JWT_SECRET_KEY'),
					signOptions: {
						expiresIn: config.get('JWT_EXPIRATION_TIME'),
					},
				}
			},
			inject: [ConfigService],
		}),
	],
	controllers: [AuthController],
	providers: [AuthService, JwtStrategy],
})
export class AuthModule {}
