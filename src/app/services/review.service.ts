import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Review} from "../classes/review";

@Injectable()
export class ReviewService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private reviewUrl = "api/review/";

	getReviewByReviewId(reviewId: number) : Observable<Review> {
		return(this.http.get(this.reviewUrl + reviewId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getReviewByReviewStudentProfileId(reviewStudentProfileId: number) : Observable<Review> {
		return(this.http.get(this.reviewUrl + "?reviewStudentProfileId=" + reviewStudentProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getReviewByReviewTutorProfileId(reviewTutorProfileId: number) : Observable<Review[]> {
		return(this.http.get(this.reviewUrl + "?reviewTutorProfileId=" + reviewTutorProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getReviewByReviewText(reviewText: string) : Observable<Review> {
		return(this.http.get(this.reviewUrl + "?reviewText=" + reviewText)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createReview(profile: Review) : Observable<Review> {
		return(this.http.post(this.reviewUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

}
