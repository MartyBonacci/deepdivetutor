///<reference path="../services/profile.service.ts"/>
import {Component, OnInit} from "@angular/core";
import {Profile} from "../classes/profile";
import {RTProfileService} from "../services/rtprofile.service";
import {ActivatedRoute, Params, Router} from "@angular/router";
import {Status} from "../classes/status";
import {SessionService} from "../services/session.service";
import {CookieService} from "ng2-cookies";
import {SkillService} from "../services/skill.service";


@Component({
	templateUrl: "./templates/rtprofile.html",
	providers: [RTProfileService]
})

export class RTProfileComponent implements OnInit {
	profiles: Profile[]=[];
	profile: Profile= new Profile(null,null,null,null,null,null,null,null,null);
	status: Status = null;

	cookieJar : any = {};

	constructor( private profileService:RTProfileService, private router:Router, private route:ActivatedRoute, protected cookieService: CookieService, protected sessionService: SessionService){}

	ngOnInit() : void {
		this.route.params.switchMap((params: Params) => this.profileService.getProfileByProfileId(+params["id"])).subscribe(profile => this.profile = profile);
			// this.profileService.getProfileByProfileId()
			// let profileId = +params["id"];
			// this.profileService.getProfile(profileId)
			// 	.subscribe(profile => this.profile = profile);

		};

	// reloadProfile(): void{
	// 	this.sessionService.setSession();
	// 	this.cookieJar = this.cookieService.getAll();
	// 	this.profileService.getProfileByProfileId(this.cookieJar['profileId'])
	// 		.subscribe (profiles=>this.profiles=profiles);
	// }
	switchProfile(profile:Profile): void{
		this.router.navigate(["/profile/", profile.profileId]);
	}
}