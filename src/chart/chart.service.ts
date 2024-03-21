import { Injectable } from '@nestjs/common'
import { PrismaService } from '../prisma/prisma.service'
import { startOfMonth, endOfMonth, subMonths } from 'date-fns'

@Injectable()
export class ChartService {
	constructor(private readonly prisma: PrismaService) {}

	async getStats() {
		const worksCount = await this.prisma.work.count({})

		const worksThisMonth = await this.prisma.work.count({
			where: {
				AND: [
					{
						createdAt: {
							gte: startOfMonth(new Date()),
						},
					},
					{
						createdAt: {
							lte: endOfMonth(new Date()),
						},
					},
				],
			},
		})

		const ordersMonth = await this.prisma.order.count({
			where: {
				AND: [
					{
						createdAt: {
							gte: startOfMonth(new Date()),
						},
					},
					{
						createdAt: {
							lte: endOfMonth(new Date()),
						},
					},
				],
			},
		})

		const ordersLastMonth = await this.prisma.order.count({
			where: {
				AND: [
					{
						createdAt: {
							gte: subMonths(startOfMonth(new Date()), 1),
						},
					},
					{
						createdAt: {
							lte: subMonths(endOfMonth(new Date()), 1),
						},
					},
				],
			},
		})

		const ordersTotal = await this.prisma.order.count({})

		return {
			works: {
				header: {
					title: 'Добавлено работ',
					value: worksCount,
				},
				content: {
					title: 'Новых в этом месяце',
					value: worksThisMonth,
				},
			},
			orders: {
				header: {
					title: 'Заказов в текущем месяце',
					value: ordersMonth ? ordersMonth : 0,
				},
				content: {
					title: 'В прошлом месяце',
					value: ordersLastMonth ? ordersLastMonth : 0,
				},
			},
			total: {
				header: {
					title: 'Всего заказов',
					value: ordersTotal,
				},
				content: {
					title: 'Начиная с',
					value: '15 марта 2024',
				},
			},
		}
	}
}
