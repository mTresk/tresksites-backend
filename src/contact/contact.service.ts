import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { ContactsDto } from './dto'
import { MediaService } from '../media/media.service'

@Injectable()
export class ContactService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly mediaService: MediaService,
  ) {}

  async findFirst() {
    const data = await this.prisma.contact.findFirst({
      include: {
        media: true,
      },
    })

    return {
      name: data.name,
      inn: data.inn,
      email: data.email,
      telegram: data.telegram,
      block: data.block,
      files: data.media[0]
        ? this.mediaService.prepareLinks(data.media[0], data.galleryId)
        : {},
    }
  }

  async update(contactsDto: ContactsDto) {
    const contacts = await this.prisma.contact.findFirst()

    await this.prisma.contact.update({
      where: {
        id: contacts.id,
      },
      data: {
        name: contactsDto.name,
        inn: contactsDto.inn,
        email: contactsDto.email,
        telegram: contactsDto.telegram,
        block: contactsDto.block,
        galleryId: contactsDto.galleryId,
      },
    })

    if (contactsDto.galleryId) {
      const mediaToRemove = await this.prisma.media.findFirst({
        where: {
          contactId: contacts.id,
        },
      })

      if (mediaToRemove) {
        await this.mediaService.remove(mediaToRemove)
      }

      const media = await this.prisma.media.create({
        data: {
          contactId: contacts.id,
        },
      })

      await this.mediaService.generate(contactsDto.galleryId, media.id)
    }

    return 'Контакты обновлены'
  }
}
