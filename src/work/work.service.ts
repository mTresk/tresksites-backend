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

    const media = await this.prisma.media.findFirst({
      where: {
        galleryId: data.galleryId,
      },
    })

    return {
      id: data.id,
      name: data.name,
      slug: data.slug,
      label: data.label,
      url: data.url,
      list: data.list,
      files: this.mediaService.prepareLinks(media, data.galleryId),
      content: await this.prepareContent(data.content, data.id),
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
        galleryId: workDto.galleryId,
      },
    })

    const media = await this.prisma.media.create({
      data: {
        workId: work.id,
      },
    })

    await this.mediaService.generate(workDto.galleryId, media.id, worksFormats)

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
    const work = await this.prisma.work.findUnique({
      where: {
        id,
      },
    })

    const data = {
      name: workDto.name,
      slug: workDto.slug,
      label: workDto.label,
      url: workDto.url,
      list: workDto.list,
      content: await this.prepareContent(workDto.content, id, work.content),
      isFeatured: workDto.isFeatured,
      galleryId: workDto.galleryId ?? work.galleryId,
    }

    if (workDto.galleryId) {
      await this.fileService.deleteFile(work.galleryId)

      await this.prisma.media.deleteMany({
        where: {
          galleryId: work.galleryId,
        },
      })

      const media = await this.prisma.media.create({
        data: {
          workId: id,
        },
      })

      await this.mediaService.generate(
        workDto.galleryId,
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
      await this.fileService.deleteFile(String(item.galleryId))
    }

    await this.prisma.media.deleteMany({
      where: {
        workId: id,
      },
    })

    await this.prisma.work.delete({ where: { id } })

    return 'Работа удалена'
  }

  private async prepareContent(content: any, id: number, prevContent?: any) {
    return Promise.all(
      content.map(async (item: WorkUpdateDto['content'], index) => {
        const data = item?.data

        const media = await this.prisma.media.findFirst({
          where: {
            galleryId: item.data.galleryId,
          },
        })

        if (media) {
          return {
            data: {
              html: item.data.html,
              galleryId: item.data.galleryId,
              files: this.mediaService.prepareLinks(media, item.data.galleryId),
            },
          }
        } else if (!media && item.data.galleryId) {
          if (prevContent) {
            // eslint-disable-next-line @typescript-eslint/no-unused-vars
            for (const content of prevContent) {
              if (prevContent[index]?.data?.galleryId) {
                await this.fileService.deleteFile(
                  prevContent[index].data.galleryId,
                )

                await this.prisma.media.deleteMany({
                  where: {
                    galleryId: prevContent[index].data.galleryId,
                  },
                })
              }
            }
          }

          const media = await this.prisma.media.create({
            data: {
              workId: id,
            },
          })

          const generated = await this.mediaService.generate(
            item.data.galleryId,
            media.id,
            worksFormats,
          )

          return {
            data: {
              html: item.data.html,
              galleryId: item.data.galleryId,
              files: this.mediaService.prepareLinks(
                generated,
                item.data.galleryId,
              ),
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
