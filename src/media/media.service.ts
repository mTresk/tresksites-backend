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

	async generate(url: string, id: number, formats?: any) {
		const conversions = await this.fileService.saveFile(url, id, formats)

		return this.prisma.media.update({
			where: {
				id,
			},
			data: {
				links: conversions,
				galleryId: url,
			},
		})
	}

	async remove(media: { id: number; galleryId: string }) {
		await this.fileService.deleteFile(media.galleryId)

		await this.prisma.media.delete({
			where: {
				id: media.id,
			},
		})
	}

	prepareLinks(data: any, galleryId: string | number) {
		const links = (data.links as any).reduce(
			(a: any, b: any) => ({ ...a, ...b }),
			{},
		)

		return {
			original: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.original}`,
			image: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.image}`,
			imageX2: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.imageX2}`,
			imageWebp: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.imageWebp}`,
			imageWebpX2: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.imageWebpX2}`,
			imageSm: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.imageSm}`,
			imageSmX2: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.imageSmX2}`,
			imageWebpSm: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.imageWebpSm}`,
			imageWebpSmX2: `${this.config.get('APP_URL')}/storage/${galleryId}/${links.imageWebpSmX2}`,
		}
	}
}
