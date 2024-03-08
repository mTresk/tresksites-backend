import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { ServiceCreateDto } from './dto'
import { FileService } from '../file/file.service'
import { ConfigService } from '@nestjs/config'
import { MediaService } from '../media/media.service'

@Injectable()
export class ServiceService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly fileService: FileService,
    private readonly config: ConfigService,
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
        images: this.prepareImageLinks(item),
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
      images: this.prepareImageLinks(data),
    }
  }

  async create(serviceDto: ServiceCreateDto) {
    const service = await this.prisma.service.create({
      data: {
        title: serviceDto.title,
        description: serviceDto.description,
      },
    })

    const media = await this.prisma.media.create({
      data: {
        serviceId: service.id,
      },
    })

    await this.mediaService.generate(serviceDto.url, media.id)

    return 'Услуга создана'
  }

  async update(id: number, serviceDto: ServiceCreateDto) {
    if (serviceDto.url) {
      await this.mediaService.remove(id)

      const media = await this.prisma.media.create({
        data: {
          serviceId: id,
        },
      })

      await this.mediaService.generate(serviceDto.url, media.id)

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
    await this.mediaService.remove(id)

    await this.prisma.service.delete({ where: { id } })

    return 'Услуга удалена'
  }

  private prepareImageLinks(data: any) {
    const links = (data.media[0].links as any).reduce(
      (a: any, b: any) => ({ ...a, ...b }),
      {},
    )

    const id = data.media[0].id

    return {
      original: `${this.config.get('APP_URL')}/storage/${id}/${links.original}`,
      image: `${this.config.get('APP_URL')}/storage/${id}/${links.image}`,
      imageX2: `${this.config.get('APP_URL')}/storage/${id}/${links.imageX2}`,
      imageWebp: `${this.config.get('APP_URL')}/storage/$.id}/${links.imageWebp}`,
      imageWebpX2: `${this.config.get('APP_URL')}/storage/${id}/${links.imageWebpX2}`,
    }
  }
}
