import {Component, ViewChild, EventEmitter, Output} from "@angular/core";

import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {SignInService} from "../services/sign-in.service"
import {SignIn} from "../classes/sign-in"
declare var $: any;

@Component({
	templateUrl: "./templates/signin.html",
	selector:"signin"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(private SignInService: SignInService, private router: Router){
	}

	signIn(): void {
		this.SignInService.createSignIn(this.signin).subscribe(status=>{
			this.status=status;
			if(status.status === 200){

				this.router.navigate([""]);
				this.signInForm.reset();
				setTimeout(function(){$("#signin-modal").modal('hide');},1000);
			}else{
				console.log("failed login")
			}
		});
	}

}

