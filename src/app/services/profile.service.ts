import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Profile} from "../classes/profile";
import {Response} from "@angular/http";

@Injectable()
export class ProfileService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private profileUrl = "api/profile/";


	getProfileByProfileId(profileId: number): Observable<Profile[]> {
		return (this.http.get(this.profileUrl + profileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileName(profileName: string): Observable<Profile[]> {
		return (this.http.get(this.profileUrl + "?profileName=" + profileName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileRate(brokeProfileRate: number, loadedProfileRate: number): Observable<Profile[]> {
		return (this.http.get(this.profileUrl + "?brokeProfileRate=" + brokeProfileRate + "&loadedProfileRate=" + loadedProfileRate)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileType(profileType: number): Observable<Profile[]> {
		return (this.http.get(this.profileUrl + "?profileType=" + profileType)
			.map(this.extractData)
			.catch(this.handleError));
	}
}



