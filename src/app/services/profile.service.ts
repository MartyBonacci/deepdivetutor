import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Response} from "@angular/http";

@Injectable()
export class ProfileService {

	constructor(protected http: Http) {
	}

	private profileUrl = "api/profile/";

	setProfile() : Observable<Response> {
		return (this.http.head(this.profileUrl)
			.map((response : Response) => response));
	}
}