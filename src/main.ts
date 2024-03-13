import { NestFactory } from '@nestjs/core'
import { AppModule } from './app.module'
import { ConfigService } from '@nestjs/config'
import { useContainer } from 'class-validator'
import { UnprocessableEntityException, ValidationPipe } from '@nestjs/common'
import * as cookieParser from 'cookie-parser'

const config = new ConfigService()

async function bootstrap() {
  const app = await NestFactory.create(AppModule)
  useContainer(app.select(AppModule), { fallbackOnErrors: true })
  app.useGlobalPipes(
    new ValidationPipe({
      whitelist: true,
      exceptionFactory: (errors) => {
        const mappedErrors = errors.map((error) => ({
          [error.property]: [
            error.constraints[Object.keys(error.constraints)[0]],
          ],
        }))

        const result = mappedErrors.reduce((a, b) => ({ ...a, ...b }), {})
        return new UnprocessableEntityException({ errors: result })
      },
    }),
  )
  app.setGlobalPrefix('api', {
    exclude: ['login', 'logout', 'register', 'user', 'storage'],
  })
  app.use(cookieParser())
  app.enableCors({
    origin: config.get('FRONTEND_URLS').split(','),
    credentials: true,
  })
  await app.listen(8000)
}

bootstrap()
