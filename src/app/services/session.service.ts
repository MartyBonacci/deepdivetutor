import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Response} from "@angular/http";

@Injectable()
export class SessionService {

	constructor(protected http: Http) {
	}

	private sessionUrl = "api/session/";

	setSession() : Observable<Response> {
		return (this.http.head(this.sessionUrl)
			.map((response : Response) => response));
	}
}