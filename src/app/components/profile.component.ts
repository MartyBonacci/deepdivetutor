///<reference path="../services/profile.service.ts"/>
import {Component, OnInit} from "@angular/core";
import {Profile} from "../classes/profile";
import {ProfileService} from "../services/profile.service";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SessionService} from "../services/session.service";
import {CookieService} from "ng2-cookies";





@Component({
	templateUrl: "./templates/profile.html",
	providers: [ProfileService]
})

export class ProfileComponent implements OnInit {
	profiles: Profile[]=[];
	profile: Profile= new Profile(null,null,null,null,null,null,null,null,null);
	status: Status = null;

	cookieJar : any = {};

	constructor( private profileService:ProfileService, private router:Router, protected cookieService: CookieService, protected sessionService: SessionService){}

	ngOnInit(): void {

		this.reloadProfile();
	}

	reloadProfile(): void{
		this.sessionService.setSession();
		this.cookieJar = this.cookieService.getAll();
		this.profileService.getProfileByProfileId(this.cookieJar['profileId'])
		.subscribe (profile=>this.profile=profile);
	}
	switchProfile(profile:Profile): void{
		this.router.navigate(["/profile/", profile.profileId]);
	}
}