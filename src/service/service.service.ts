import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { ServiceCreateDto } from './dto'
import { MediaService } from '../media/media.service'
import { ServiceUpdateDto } from './dto/service-update.dto'

@Injectable()
export class ServiceService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly mediaService: MediaService,
  ) {}

  async findAll() {
    const data: any = await this.prisma.service.findMany({
      include: {
        media: true,
      },
    })

    return data.map((item: any) => {
      return {
        id: item.id,
        title: item.title,
        description: item.description,
        files: this.mediaService.prepareLinks(item.media[0], item.galleryId),
        createdAt: item.createdAt,
      }
    })
  }

  async findOne(id: number) {
    const data = await this.prisma.service.findUnique({
      where: {
        id: id,
      },
      include: {
        media: true,
      },
    })

    return {
      id: data.id,
      title: data.title,
      description: data.description,
      createdAt: data.createdAt,
      files: this.mediaService.prepareLinks(data.media[0], data.galleryId),
    }
  }

  async create(serviceDto: ServiceCreateDto) {
    const service = await this.prisma.service.create({
      data: {
        title: serviceDto.title,
        description: serviceDto.description,
        galleryId: serviceDto.galleryId,
      },
    })

    const media = await this.prisma.media.create({
      data: {
        serviceId: service.id,
      },
    })

    await this.mediaService.generate(serviceDto.galleryId, media.id)

    return 'Услуга создана'
  }

  async update(id: number, serviceDto: ServiceUpdateDto) {
    if (serviceDto.galleryId) {
      const mediaToRemove = await this.prisma.media.findFirst({
        where: {
          serviceId: id,
        },
      })

      await this.mediaService.remove(mediaToRemove)

      const media = await this.prisma.media.create({
        data: {
          serviceId: id,
        },
      })

      await this.mediaService.generate(serviceDto.galleryId, media.id)

      await this.prisma.service.update({
        where: {
          id: id,
        },
        data: {
          title: serviceDto.title,
          description: serviceDto.description,
        },
      })
    } else
      await this.prisma.service.update({
        where: {
          id: id,
        },
        data: {
          title: serviceDto.title,
          description: serviceDto.description,
        },
      })

    return 'Услуга обновлена'
  }

  async remove(id: number) {
    const media = await this.prisma.media.findFirst({
      where: {
        serviceId: id,
      },
    })

    await this.mediaService.remove(media)

    await this.prisma.service.delete({ where: { id } })

    return 'Услуга удалена'
  }
}
