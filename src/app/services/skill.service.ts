import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Response} from "@angular/http";

@Injectable()
export class SkillService {

	constructor(protected http: Http) {
	}

	private sessionUrl = "api/skill/";

	setSession() : Observable<Response> {
		return (this.http.head(this.skillUrl)
			.map((response : Response) => response));
	}
}