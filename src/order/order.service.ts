import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { OrderDto } from './dto'
import { ConfigService } from '@nestjs/config'
import { FileService } from '../file/file.service'

@Injectable()
export class OrderService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly config: ConfigService,
    private readonly fileService: FileService,
  ) {}

  async findAll() {
    return this.prisma.order.findMany({})
  }

  async findOne(id: number) {
    const order = await this.prisma.order.findUnique({
      where: {
        id: id,
      },
    })

    return {
      id: order.id,
      name: order.name,
      phone: order.phone,
      email: order.email,
      message: order.message,
      attachment: `${this.config.get('APP_URL')}/storage/attachments/${order.attachment}`,
    }
  }

  async create(orderDto: OrderDto, filename: string) {
    await this.prisma.order.create({
      data: {
        name: orderDto.name,
        phone: orderDto.phone,
        email: orderDto.email,
        message: orderDto.message,
        attachment: filename,
      },
    })

    return 'Заказ создан'
  }

  async remove(id: number) {
    const order = await this.prisma.order.delete({ where: { id } })

    if (order.attachment) {
      await this.fileService.deleteFile(`attachments/${order.attachment}`)
    }

    return 'Заказ удален'
  }
}
