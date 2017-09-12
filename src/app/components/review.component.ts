import {Component, OnInit, ViewChild} from "@angular/core";
import {ActivatedRoute, Params, Router} from "@angular/router";
import {Observable} from "rxjs";
import {Review} from "../classes/review";
import {ReviewService} from "../services/review.service";
import {Status} from "../classes/status";
import {SessionService} from "../services/session.service";
import {CookieService} from "ng2-cookies";

@Component({
	selector: "review-content",
	templateUrl: "./templates/review.html",
	providers: [ReviewService]
})

export class ReviewComponent implements OnInit {
	@ViewChild("reviewForm") reviewForm: any;
	reviews: Review[] = [];
	review: Review = new Review(null, null, null, null, null, null);
	status: Status = null;

	cookieJar : any = {};

	constructor(private reviewService: ReviewService, private router: Router, protected cookieService: CookieService, protected sessionService: SessionService) {}


	ngOnInit(): void {
		this.reloadReviews();
	}

	reloadReviews(): void {
		this.sessionService.setSession();
		this.cookieJar = this.cookieService.getAll();
		this.reviewService.getReviewByReviewTutorProfileId(this.cookieJar['profileId'])
			.subscribe(reviews => this.reviews = reviews);
	}

	switchReview(review: Review): void {
		this.router.navigate(["/review/", review.reviewId]);
	}

	createReview() : void {
		this.reviewService.createReview(this.review)
			.subscribe(status => {
				this.status=status;
				if(status.status === 200){
					this.reloadReviews();
					this.reviewForm.reset();
				}
			});
	}

}
