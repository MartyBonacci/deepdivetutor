import {Component, OnInit} from "@angular/core";
import {SessionService} from "../services/session.service";

@Component({
	selector: "angular4-webpack-devserver",
	templateUrl: "./templates/angular4-webpack-devserver.html"
})

export class AppComponent implements OnInit {

	constructor(protected sessionService: SessionService) {}

	ngOnInit() : void {
		this.sessionService.setSession();
	}


}