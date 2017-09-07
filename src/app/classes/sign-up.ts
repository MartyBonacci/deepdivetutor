export class SignUp {
	constructor(
		public profileName: string,
		public profileEmail: string,
		public profileType: number,
		public profileBio: string,
		public profileRate: number,
		public profilePassword: string,
		public profilePasswordConfirm: string
	) {}
}
