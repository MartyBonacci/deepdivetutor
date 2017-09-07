import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {SignIn} from "../classes/sign-in"

@Injectable()

export class SignInService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signInUrl = "api/sign-in/";
	public isSignedIn = false;

	createSignIn(signIn: SignIn): Observable<Status> {
		return (this.http.post(this.signInUrl, signIn).map(this.extractMessage).catch(this.handleError));
	}
}

export class SignOutService extends BaseService{
	constructor(protected http:Http){
		super (http);
	}
	private signOutUrl= "api/sign-out/"
	getSignOut():Observable<Status>{
		return(this.http.get(this.signOutUrl).map(this.extractMessage)
			.catch(this.handleError));
	}
}