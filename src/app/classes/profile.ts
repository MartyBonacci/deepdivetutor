export class Profile {
	constructor(
		public profileId: number,
		public profileName: string,
		public profileEmail: string,
		public profileType: number,
		public profileGithubToken: string,
		public profileBio: string,
		public profileRate: number,
		public profileImage: number,
		public profileLastEditDateTime: string,
		public profileActivationToken: string,
		public profileHash: string,
		public profileSalt: string
	) {}
}