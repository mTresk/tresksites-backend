import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { OrderDto } from './dto'
import { ConfigService } from '@nestjs/config'
import { FileService } from '../file/file.service'
import { EventEmitter2 } from '@nestjs/event-emitter'
import { OrderReceivedEvent } from '../events/order-received-event'

@Injectable()
export class OrderService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly config: ConfigService,
    private readonly fileService: FileService,
    private readonly eventEmitter: EventEmitter2,
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
    const order = await this.prisma.order.create({
      data: {
        name: orderDto.name,
        phone: orderDto.phone,
        email: orderDto.email,
        message: orderDto.message,
        attachment: filename,
      },
    })

    this.eventEmitter.emit(
      'order.received',
      new OrderReceivedEvent(
        order.name,
        order.phone,
        order.email,
        order.message,
        order.attachment,
      ),
    )

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
