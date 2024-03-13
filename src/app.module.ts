import { Module } from '@nestjs/common'
import { PrismaModule } from './prisma/prisma.module'
import { ConfigModule } from '@nestjs/config'
import { ServiceModule } from './service/service.module'
import { MulterModule } from '@nestjs/platform-express'
import { memoryStorage } from 'multer'
import { FileModule } from './file/file.module'
import { ServeStaticModule } from '@nestjs/serve-static'
import { join } from 'path'
import { MediaModule } from './media/media.module'
import { WorkModule } from './work/work.module'
import { ContactModule } from './contact/contact.module'
import { PriceModule } from './price/price.module'
import { PolicyModule } from './policy/policy.module'
import { OrderModule } from './order/order.module'

@Module({
  imports: [
    MulterModule.register({
      storage: memoryStorage(),
    }),
    ConfigModule.forRoot({
      isGlobal: true,
    }),
    ServeStaticModule.forRoot({
      rootPath: join(__dirname, '..'),
      serveStaticOptions: { index: false },
    }),
    PrismaModule,
    ServiceModule,
    FileModule,
    MediaModule,
    WorkModule,
    ContactModule,
    PriceModule,
    PolicyModule,
    OrderModule,
  ],
  controllers: [],
  providers: [],
})
export class AppModule {}
