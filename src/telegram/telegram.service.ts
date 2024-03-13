import { Injectable } from '@nestjs/common'
import * as TelegramBot from 'node-telegram-bot-api'
import { OnEvent } from '@nestjs/event-emitter'
import { ConfigService } from '@nestjs/config'
import { OrderReceivedEvent } from '../events/order-received-event'

@Injectable()
export class TelegramService {
  constructor(private readonly config: ConfigService) {}

  @OnEvent('order.received', { async: true })
  async handleOrderReceivedEvent(event: OrderReceivedEvent) {
    await this.sendOrderReceived(event)
  }

  async sendOrderReceived(payload: OrderReceivedEvent) {
    const message = `
<b>Получен новый заказ!</b>

Имя: <b>${payload.name}</b>
Телефон: <b>${payload.phone}</b>
Email: <b>${payload.email}</b>
Сообщение: <b>${payload.message}</b>`

    await this.sendMessage(message)
  }

  async sendMessage(message: string) {
    const token = this.config.get('TELEGRAM_BOT_TOKEN')
    const chatId = this.config.get('TELEGRAM_CHAT_ID')
    const bot = new TelegramBot(token, {})

    return bot.sendMessage(chatId, message, { parse_mode: 'HTML' })
  }
}
