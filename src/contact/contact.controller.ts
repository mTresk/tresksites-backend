import { Body, Controller, Get, Put, UseGuards } from '@nestjs/common'
import { ContactService } from './contact.service'
import { ContactsDto } from './dto'
import { JwtGuard, RolesGuard } from '../auth/guard'

@Controller('contacts')
export class ContactController {
	constructor(private readonly contactService: ContactService) {}

	@Get()
	findFirst() {
		return this.contactService.findFirst()
	}

	@UseGuards(JwtGuard, RolesGuard)
	@Put('update')
	update(@Body() contactsDto: ContactsDto) {
		return this.contactService.update(contactsDto)
	}
}
