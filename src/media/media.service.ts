import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { ConfigService } from '@nestjs/config'
import { FileService } from '../file/file.service'

@Injectable()
export class MediaService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly config: ConfigService,
    private readonly fileService: FileService,
  ) {}

  async generate(url: string, id: number, formats?: any): Promise<void> {
    const conversions = await this.fileService.saveFile(url, id, formats)

    await this.prisma.media.update({
      where: {
        id,
      },
      data: {
        links: conversions,
      },
    })
  }

  prepareLinks(data: any) {
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

  async remove(id: number): Promise<void> {
    const media = await this.prisma.media.findFirst({
      where: {
        serviceId: id,
      },
    })

    await this.fileService.deleteFile(String(media.id))

    await this.prisma.media.delete({
      where: {
        id: media.id,
      },
    })
  }
}
