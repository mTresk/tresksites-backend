import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { WorkCreateDto } from './dto'
import { MediaService } from '../media/media.service'
import { WorkUpdateDto } from './dto/work-update.dto'
import { FileService } from '../file/file.service'
import { worksFormats } from '../formats'

@Injectable()
export class WorkService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly mediaService: MediaService,
    private readonly fileService: FileService,
  ) {}

  async findAll() {
    return this.prisma.work.findMany({})
  }

  async findOne(id: number) {
    const data = await this.prisma.work.findUnique({
      where: {
        id: id,
      },
      include: {
        media: true,
      },
    })

    return {
      id: data.id,
      name: data.name,
      slug: data.slug,
      label: data.label,
      url: data.url,
      list: data.list,
      images: this.mediaService.prepareLinks(data.media[0]),
      content: await this.prepareContent(data.content),
      isFeatured: data.isFeatured,
    }
  }

  async create(workDto: WorkCreateDto) {
    const work = await this.prisma.work.create({
      data: {
        name: workDto.name,
        slug: workDto.slug,
        label: workDto.label,
        url: workDto.url,
        list: workDto.list,
        content: workDto.content,
        isFeatured: workDto.isFeatured,
      },
    })

    const media = await this.prisma.media.create({
      data: {
        workId: work.id,
      },
    })

    await this.mediaService.generate(
      workDto.featuredImage,
      media.id,
      worksFormats,
    )

    const content: any = work.content

    if (content) {
      for (const item of content) {
        const media = await this.prisma.media.create({
          data: {
            workId: work.id,
          },
        })

        await this.mediaService.generate(
          item.data.galleryId,
          media.id,
          worksFormats,
        )
      }
    }

    return 'Работа создана'
  }

  async update(id: number, workDto: WorkUpdateDto) {
    const data = {
      name: workDto.name,
      slug: workDto.slug,
      label: workDto.label,
      url: workDto.url,
      list: workDto.list,
      content: await this.prepareContent(workDto.content),
      isFeatured: workDto.isFeatured,
    }

    if (workDto.featuredImage) {
      const mediaToRemove = await this.prisma.media.findFirst({
        where: {
          workId: id,
        },
      })

      await this.mediaService.remove(mediaToRemove.id)

      const media = await this.prisma.media.create({
        data: {
          workId: id,
        },
      })

      await this.mediaService.generate(
        workDto.featuredImage,
        media.id,
        worksFormats,
      )

      await this.prisma.work.update({
        where: {
          id: id,
        },
        data,
      })
    } else {
      await this.prisma.work.update({
        where: {
          id: id,
        },
        data,
      })
    }

    return 'Работа обновлена'
  }

  async remove(id: number) {
    const media = await this.prisma.media.findMany({
      where: {
        workId: id,
      },
    })

    for (const item of media) {
      await this.fileService.deleteFile(String(item.id))
    }

    await this.prisma.media.deleteMany({
      where: {
        workId: id,
      },
    })

    await this.prisma.work.delete({ where: { id } })

    return 'Работа удалена'
  }

  private async prepareContent(content: any) {
    return Promise.all(
      content.map(async (item: WorkUpdateDto['content']) => {
        const data = item?.data

        if (!item?.data?.images && item?.data?.galleryId) {
          const image = await this.prisma.media.findFirst({
            where: {
              galleryId: item.data.galleryId,
            },
          })

          return {
            data: {
              html: item.data.html,
              images: this.mediaService.prepareLinks(image),
            },
          }
        } else {
          return {
            data,
          }
        }
      }),
    )
  }
}
