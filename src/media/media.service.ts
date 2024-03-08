import { Injectable } from '@nestjs/common'
import * as fs from 'fs'
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

  async generate(url: string, id: number, formats?: any) {
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

  async remove(id: number): Promise<void> {
    const media = await this.prisma.media.findFirst({
      where: {
        serviceId: id,
      },
    })

    fs.rm(
      `${this.config.get('NODE_PATH')}storage/${media.id}`,
      { recursive: true },
      (error) => {
        if (error) console.log(error)
      },
    )

    await this.prisma.media.delete({
      where: {
        id: media.id,
      },
    })
  }
}
