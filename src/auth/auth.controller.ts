import {
  Body,
  Controller,
  Get,
  HttpCode,
  HttpStatus,
  Post,
  Res,
  UseGuards,
} from '@nestjs/common'
import { AuthService } from './auth.service'
import { LoginDto } from './dto'
import { GetUser } from './decorator'
import { User } from '@prisma/client'
import { JwtGuard } from './guard'

@Controller()
export class AuthController {
  constructor(private authService: AuthService) {}

  @HttpCode(HttpStatus.OK)
  @Post('login')
  login(@Body() dto: LoginDto, @Res({ passthrough: true }) res: any) {
    return this.authService.login(dto, res)
  }

  @UseGuards(JwtGuard)
  @Post('logout')
  logout(@Res({ passthrough: true }) res: any) {
    return this.authService.logout(res)
  }

  @UseGuards(JwtGuard)
  @Get('user')
  getCurrentUser(@GetUser() user: User) {
    return user
  }
}
