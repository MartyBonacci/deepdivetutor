import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Profile} from "../classes/profile";

@Injectable()
export class ProfileService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private profileUrl = "api/profile/";

	getProfileByProfileId(profileId: number) : Observable<Profile> {
		return(this.http.get(this.profileUrl + profileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileName(profileName: string) : Observable<Profile> {
		return(this.http.get(this.profileUrl + profileName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileRate(profileRate: number) : Observable<Profile> {
		return(this.http.get(this.profileUrl + profileRate)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileType(profileType: number) : Observable<Profile> {
		return(this.http.get(this.profileUrl + profileType)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createProfile(profile: Profile) : Observable<Profile> {
		return(this.http.post(this.profileUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

}
