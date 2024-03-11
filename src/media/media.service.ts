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
        galleryId: url,
      },
    })
  }

  async remove(id: number) {
    await this.fileService.deleteFile(String(id))

    await this.prisma.media.delete({
      where: {
        id: id,
      },
    })
  }

  prepareLinks(data: any) {
    const links = (data.links as any).reduce(
      (a: any, b: any) => ({ ...a, ...b }),
      {},
    )

    return {
      original: `${this.config.get('APP_URL')}/storage/${data.id}/${links.original}`,
      image: `${this.config.get('APP_URL')}/storage/${data.id}/${links.image}`,
      imageX2: `${this.config.get('APP_URL')}/storage/${data.id}/${links.imageX2}`,
      imageWebp: `${this.config.get('APP_URL')}/storage/${data.id}/${links.imageWebp}`,
      imageWebpX2: `${this.config.get('APP_URL')}/storage/${data.id}/${links.imageWebpX2}`,
    }
  }
}
