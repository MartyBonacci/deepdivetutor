import {Component} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";

declare var $: any;

@Component({
	templateUrl: "./templates/sign-in.html",
	selector:"signin"
})

export class SignInComponent {

	signin: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(private signInService: SignInService, private router: Router){
	}

	signIn(): void {
		this.signInService.createSignIn(this.signin).subscribe(status=>{
			this.status=status;
			if(status.status === 200){

				this.router.navigate(["profile"]);
			} else {
				console.log("failed login");
			}
		});
	}

}

