import {Component, OnInit} from "@angular/core";
import {SessionService} from "../services/session.service";

@Component({
	selector: "deep-dive-tutor",
	templateUrl: "./templates/deep-dive-tutor.html"
})

export class AppComponent implements OnInit {

	constructor(protected sessionService: SessionService) {}

	ngOnInit() : void {
		this.sessionService.setSession();
	}
}