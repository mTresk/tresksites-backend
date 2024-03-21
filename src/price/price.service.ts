import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { PriceDto } from './dto'

@Injectable()
export class PriceService {
	constructor(private readonly prisma: PrismaService) {}

	async findFirst() {
		return this.prisma.price.findFirst({
			select: {
				title: true,
				description: true,
				block: true,
			},
		})
	}

	async update(priceDto: PriceDto) {
		const price = await this.prisma.price.findFirst()

		if (!price) {
			await this.prisma.price.create({
				data: priceDto,
			})
		} else {
			await this.prisma.price.update({
				where: {
					id: price.id,
				},
				data: priceDto,
			})
		}

		return 'Цены обновлены'
	}
}
