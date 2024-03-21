import { MailerService } from '@nestjs-modules/mailer'
import { Injectable } from '@nestjs/common'
import { OnEvent } from '@nestjs/event-emitter'
import { ConfigService } from '@nestjs/config'
import { OrderReceivedEvent } from '../events/order-received-event'

@Injectable()
export class MailService {
	constructor(
		private readonly mailerService: MailerService,
		private readonly config: ConfigService,
	) {}

	@OnEvent('order.received')
	async handleOrderReceivedEvent(event: OrderReceivedEvent) {
		await this.sendOrderReceived(event)
	}

	async sendOrderReceived(payload: OrderReceivedEvent) {
		let attachment = null

		if (payload.attachment) {
			attachment = `${this.config.get('NODE_PATH')}storage/attachments/${payload.attachment}`
		}

		await this.mailerService.sendMail({
			to: this.config.get('MAIL_ADMIN_EMAIL'),
			subject: 'Заказ с tresksites.ru!',
			template: './order-received',
			context: {
				name: payload.name,
				phone: payload.phone,
				email: payload.email,
				message: payload.message,
			},
			attachments: [
				{
					// filename: payload.fileName,
					path: attachment,
				},
			],
		})
	}
}
