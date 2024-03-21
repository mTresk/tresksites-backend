import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { PolicyDto } from './dto'

@Injectable()
export class PolicyService {
	constructor(private readonly prisma: PrismaService) {}

	async findFirst() {
		return this.prisma.policy.findFirst()
	}

	async update(policyDto: PolicyDto) {
		const policy = await this.prisma.policy.findFirst()

		if (!policy) {
			await this.prisma.policy.create({
				data: policyDto,
			})
		} else {
			await this.prisma.policy.update({
				where: {
					id: policy.id,
				},
				data: policyDto,
			})
		}

		return 'Данные обновлены'
	}
}
