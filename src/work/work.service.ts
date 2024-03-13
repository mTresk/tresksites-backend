import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { WorkCreateDto } from './dto'
import { MediaService } from '../media/media.service'
import { WorkUpdateDto } from './dto/work-update.dto'
import { FileService } from '../file/file.service'
import prisma from '../prisma/extentions/find-many-and-count'
import { worksFormats } from '../formats'

@Injectable()
export class WorkService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly mediaService: MediaService,
    private readonly fileService: FileService,
  ) {}

  async findAll(query: any) {
    const perPage = query.perPage

    const [works, count] = await prisma.work.findManyAndCount({
      include: {
        media: true,
      },
      skip: query.page ? +query.page * perPage : 0,
      take: perPage ? +perPage : 100,
      orderBy: {
        createdAt: 'desc',
      },
    })

    const data = await Promise.all(
      works.map(async (item: any) => {
        const media = await this.prisma.media.findFirst({
          where: {
            galleryId: item.galleryId,
          },
        })

        return {
          id: item.id,
          name: item.name,
          slug: item.slug,
          label: item.label,
          url: item.url,
          list: item.list,
          files: this.mediaService.prepareLinks(media, item.galleryId),
          isFeatured: item.isFeatured,
          createdAt: item.createdAt,
        }
      }),
    )

    const lastPage = Math.floor(count / perPage)

    return {
      data,
      meta: {
        lastPage,
        total: count,
      },
    }
  }

  async findFeatured() {
    const works: any = await this.prisma.work.findMany({
      where: {
        isFeatured: true,
      },
      include: {
        media: true,
      },
    })

    return Promise.all(
      works.map(async (item: any) => {
        const media = await this.prisma.media.findFirst({
          where: {
            galleryId: item.galleryId,
          },
        })

        return {
          id: item.id,
          name: item.name,
          slug: item.slug,
          label: item.label,
          url: item.url,
          list: item.list,
          files: this.mediaService.prepareLinks(media, item.galleryId),
          isFeatured: item.isFeatured,
        }
      }),
    )
  }

  async findOne(slug: string) {
    const data = await this.prisma.work.findUnique({
      where: {
        slug,
      },
      include: {
        media: true,
        seo: true,
      },
    })

    const media = await this.prisma.media.findFirst({
      where: {
        galleryId: data.galleryId,
      },
    })

    const count = await prisma.work.count()
    const skip = Math.floor(Math.random() * count)

    const other = await this.prisma.work.findMany({
      where: {
        NOT: {
          slug,
        },
      },
      skip,
      take: 3,
    })

    const otherWorks = await Promise.all(
      other.map(async (item: any) => {
        const media = await this.prisma.media.findFirst({
          where: {
            galleryId: item.galleryId,
          },
        })

        return {
          id: item.id,
          name: item.name,
          slug: item.slug,
          label: item.label,
          url: item.url,
          list: item.list,
          files: this.mediaService.prepareLinks(media, item.galleryId),
        }
      }),
    )

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
      seo: data.seo[0],
      otherWorks,
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

    await this.prisma.seo.create({
      data: {
        workId: work.id,
        ...workDto.seo,
      },
    })

    const content: any = work.content

    if (content) {
      for (const item of content) {
        if (item.galleryId) {
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
    }

    return 'Работа создана'
  }

  async update(slug: string, workDto: WorkUpdateDto) {
    const work = await this.prisma.work.findFirst({
      where: {
        slug,
      },
    })

    const data = {
      name: workDto.name,
      slug: workDto.slug,
      label: workDto.label,
      url: workDto.url,
      list: workDto.list,
      content: await this.prepareContent(
        workDto.content,
        work.id,
        work.content,
      ),
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
          workId: work.id,
        },
      })

      await this.mediaService.generate(
        workDto.galleryId,
        media.id,
        worksFormats,
      )

      await this.prisma.work.update({
        where: {
          id: work.id,
        },
        data,
      })

      await this.prisma.seo.updateMany({
        where: {
          workId: work.id,
        },
        data: workDto.seo,
      })
    } else {
      await this.prisma.work.update({
        where: {
          id: work.id,
        },
        data,
      })

      await this.prisma.seo.updateMany({
        where: {
          workId: work.id,
        },
        data: workDto.seo,
      })
    }

    return 'Работа обновлена'
  }

  async remove(slug: string) {
    const work = await this.prisma.work.findUnique({ where: { slug } })

    const media = await this.prisma.media.findMany({
      where: {
        workId: work.id,
      },
    })

    for (const item of media) {
      await this.fileService.deleteFile(item.galleryId)
    }

    await this.prisma.media.deleteMany({
      where: {
        workId: work.id,
      },
    })

    await this.prisma.work.delete({ where: { slug } })

    return 'Работа удалена'
  }

  private async prepareContent(content: any, id: number, prevContent?: any) {
    return Promise.all(
      content.map(async (item: WorkUpdateDto['content'], index: number) => {
        const data = item?.data

        const media = await this.prisma.media.findFirst({
          where: {
            galleryId: item.data.galleryId,
          },
        })

        if (media && item.data.galleryId) {
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
