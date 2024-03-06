import { NestFactory } from '@nestjs/core'
import { AppModule } from './app.module'

async function bootstrap() {
  const app = await NestFactory.create(AppModule)
  app.setGlobalPrefix('api', {
    exclude: ['login', 'logout', 'register', 'user'],
  })
  await app.listen(8000)
}

bootstrap()
