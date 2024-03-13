import { Injectable, StreamableFile } from '@nestjs/common'
import { createReadStream } from 'fs'
import { join } from 'path'
import * as fs from 'fs'
import * as path from 'path'
import { PrismaService } from '../prisma/prisma.service'
import { ConfigService } from '@nestjs/config'
import { TemporaryFile } from '@prisma/client'
import * as sharp from 'sharp'

@Injectable()
export class FileService {
  constructor(
    private readonly prisma: PrismaService,
    private readonly config: ConfigService,
  ) {}

  async getFile(url: string) {
    const file = createReadStream(
      join(this.config.get('NODE_PATH') + 'storage/', url),
    )

    return new StreamableFile(file)
  }

  async uploadTemporaryFile(file: Express.Multer.File) {
    if (file) {
      const fileName = file.originalname

      const folder = `${Math.floor(Math.random() * Date.now()).toString(36)}${Math.floor(Math.random() * Date.now()).toString(36)}`

      const destinationFolder = `${this.config.get('NODE_PATH')}storage/tmp/${folder}`

      if (!fs.existsSync(destinationFolder)) {
        fs.mkdirSync(destinationFolder, {
          recursive: true,
        })
      }

      fs.writeFile(`${destinationFolder}/${fileName}`, file.buffer, (error) => {
        if (error) console.log(error)
      })

      await this.prisma.temporaryFile.create({
        data: {
          folder: folder,
          file: fileName,
        },
      })

      return folder
    }
  }

  async saveAttachment(file: Express.Multer.File) {
    const fileName = `${crypto.randomUUID()}${path.extname(file.originalname)}`

    const destinationFolder = `${this.config.get('NODE_PATH')}storage/attachments`

    if (!fs.existsSync(destinationFolder)) {
      fs.mkdirSync(destinationFolder, {
        recursive: true,
      })
    }

    fs.writeFile(`${destinationFolder}/${fileName}`, file.buffer, (error) => {
      if (error) console.log(error)
    })

    return fileName
  }

  async deleteTemporaryFile(folder: string) {
    if (folder) {
      fs.rm(
        `${this.config.get('NODE_PATH')}storage/tmp/${folder}`,
        { recursive: true },
        (error) => {
          if (error) console.log(error)
        },
      )
    }
  }

  async saveFile(folder: string, id: number, formats?: any) {
    const temporaryFile = await this.prisma.temporaryFile.findFirst({
      where: {
        folder,
      },
    })

    if (temporaryFile) {
      const conversions = []

      const fileName = `${crypto.randomUUID()}-original${path.extname(temporaryFile.file)}`

      const destinationFolder = `${this.config.get('NODE_PATH')}storage/${folder}`

      if (!fs.existsSync(destinationFolder)) {
        fs.mkdirSync(destinationFolder, {
          recursive: true,
        })
      }

      fs.cp(
        `${this.config.get('NODE_PATH')}storage/tmp/${temporaryFile.folder}/${temporaryFile.file}`,
        `${destinationFolder}/${fileName}`,
        (error) => {
          if (error) console.log(error)
        },
      )

      conversions.push({ original: fileName })

      if (formats) {
        for (const format of formats) {
          const fileName = await this.convertImage(temporaryFile, format)

          conversions.push({ [format.name]: fileName })
        }
      }

      await this.prisma.temporaryFile.delete({
        where: {
          id: temporaryFile.id,
        },
      })

      fs.rm(
        `${this.config.get('NODE_PATH')}storage/tmp/${temporaryFile.folder}`,
        { recursive: true },
        (error) => {
          if (error) console.log(error)
        },
      )

      return conversions
    }
  }

  async deleteFile(url: string) {
    fs.rm(
      `${this.config.get('NODE_PATH')}storage/${url}`,
      { recursive: true },
      (error) => {
        if (error) console.log(error)
      },
    )
  }

  private async convertImage(temporaryFile: TemporaryFile, format?: any) {
    let fileName: string

    const temporaryPath = `${this.config.get('NODE_PATH')}storage/tmp/${temporaryFile.folder}/${
      temporaryFile.file
    }`

    const destinationFolder = `${this.config.get('NODE_PATH')}storage/${temporaryFile.folder}`

    if (!fs.existsSync(destinationFolder)) {
      fs.mkdirSync(destinationFolder, {
        recursive: true,
      })
    }

    if (format) {
      fileName = `${crypto.randomUUID()}-${format.name}.${format.format}`

      await sharp(temporaryPath)
        .resize(format.width, null, { fit: format.fit })
        .toFormat(format.format)
        .toFile(`${destinationFolder}/${fileName}`)
    }

    return fileName
  }
}
