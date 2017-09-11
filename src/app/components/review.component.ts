import {Component, OnInit, ViewChild} from "@angular/core";
import {ActivatedRoute, Params, Router} from "@angular/router";
import{Observable} from "rxjs";
import {Review} from "../classes/review";
import {ReviewService} from "../services/review.service";
import {Status} from "../classes/status";

@Component({
	selector: "review-content",
	templateUrl:"./templates/review.html"
})

	export class ReviewComponent implements OnInit{
	reviews: Review[]= [] ;
	review: Review = new Review(null,null,null,null,null,null);
	status: Status = null;

	constructor( private reviewService: ReviewService, private router:Router){}

		ngOnInit() : void{
			this.reloadReviews();
		}

		reloadReviews(): void {
			this.reviewService.getReviewByReviewTutorProfileId(255)
			.subscribe(reviews=>this.reviews = reviews);
		}
		switchReview(review: Review): void{
		this.router.navigate(["/review/", review.reviewId]);
		 }

	}
