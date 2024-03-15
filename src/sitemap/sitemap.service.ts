import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'

@Injectable()
export class SitemapService {
  constructor(private readonly prisma: PrismaService) {}

  async getWorksSitemap() {
    return this.prisma.work.findMany({
      select: {
        slug: true,
        updatedAt: true,
      },
    })
  }
}
