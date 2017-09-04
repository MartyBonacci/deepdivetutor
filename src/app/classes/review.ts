export class Review {
	constructor(
		public reviewId: number,
		public reviewStudentProfileId: number,
		public reviewTutorProfileId: number,
		public reviewRating: number,
		public reviewText: string,
		public reviewDateTime: string
	) {}
}