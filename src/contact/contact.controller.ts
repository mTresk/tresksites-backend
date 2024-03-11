import { Body, Controller, Get, Put } from '@nestjs/common'
import { ContactService } from './contact.service'
import { ContactsDto } from './dto'

@Controller('contacts')
export class ContactController {
  constructor(private readonly contactService: ContactService) {}

  @Get()
  findFirst() {
    return this.contactService.findFirst()
  }

  @Put('update')
  update(@Body() contactsDto: ContactsDto) {
    return this.contactService.update(contactsDto)
  }
}
