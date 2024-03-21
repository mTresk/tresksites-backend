export class OrderReceivedEvent {
	constructor(
		public name: string,
		public phone: string,
		public email?: string,
		public message?: string,
		public attachment?: string,
	) {}
}
