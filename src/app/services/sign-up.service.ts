import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Profile} from "../classes/profile";

@Injectable()
export class SignUpService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signUpUrl = "api/sign-up/";

	createProfile(profile: Profile) : Observable<Profile> {
		return(this.http.post(this.signUpUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

}