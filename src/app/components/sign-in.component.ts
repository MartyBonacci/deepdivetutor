import {Component, ViewChild, EventEmitter, Output} from "@angular/core";

import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {SignInSevice} from "../services/sign-in.service"
import {SignIn} from "../classes/sign-in"
declare var $: any;

@Component({
	templateUrl: "./templates/signin.php",
	selector:"isgnin"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(private SignInService: SignInService, private Router: Router){

	}
}